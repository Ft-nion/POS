<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

// Recibe los productos como prop
const props = defineProps<{ products: any[] }>();

const form = ref({
    date: new Date().toISOString().slice(0, 16),
    items: [],
    total: 0,
});

const search = ref('');
const suggestions = ref<any[]>([]);

function onProductInput() {
    const value = search.value.trim().toLowerCase();
    if (!value) {
        suggestions.value = [];
        return;
    }
    suggestions.value = props.products.filter(
        p =>
            p.status && // Solo productos activos
            ((p.name && p.name.toLowerCase().includes(value)) ||
            (p.barcode && p.barcode.toLowerCase().includes(value)))
    );
}

function selectProduct(product: any) {
    type SaleItem = {
        product_id: number;
        name: string;
        barcode: string;
        quantity: number;
        price: number;
        stock: number;
    };

    if (!form.value.items) {
        form.value.items = [];
    }

    const existing = (form.value.items as SaleItem[]).find(item => item.product_id === product.id);
    if (existing) {
        if (existing.quantity + 1 > product.stock) {
            alert('No hay suficiente stock para este producto.');
            return;
        }
        existing.quantity += 1;
    } else {
        if (product.stock < 1) {
            alert('No hay stock disponible para este producto.');
            return;
        }
        if (!product.status) {
            alert('Este producto está inactivo y no se puede vender.');
            return;
        }
        (form.value.items as SaleItem[]).push({
            product_id: product.id,
            name: product.name,
            barcode: product.barcode,
            quantity: 1,
            price: product.sale_price,
            stock: product.stock,
        });
    }
    search.value = '';
    suggestions.value = [];
}

function removeItem(idx: number) {
    form.value.items.splice(idx, 1);
}

function calculateTotal() {
    form.value.total = form.value.items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
}

function submit() {
    calculateTotal();
    const payload = {
        ...form.value,
        items: form.value.items.map(({ product_id, quantity, price }) => ({
            product_id, quantity, price
        }))
    };
    router.post('/sales', payload);
}
</script>

<template>
    <Head title="Nueva venta" />
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Registrar venta</h1>
            <div v-if="$page.props.flash.error" class="mb-4 rounded bg-red-100 text-red-700 px-4 py-2">
                {{ $page.props.flash.error }}
            </div>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Fecha</label>
                    <input v-model="form.date" type="datetime-local" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Buscar producto</label>
                    <div class="relative">
                        <input
                            v-model="search"
                            @input="onProductInput"
                            @keydown.enter.prevent="
                                () => {
                                    if (suggestions.length) {
                                        selectProduct(suggestions[0]);
                                    }
                                }
                            "
                            type="text"
                            placeholder="Nombre o código de barras"
                            class="border rounded px-2 py-1 w-full"
                            autocomplete="off"
                        />
                        <ul v-if="suggestions.length" class="absolute border rounded shadow z-10 w-full max-h-40 overflow-auto">
                            <li
                                v-for="suggestion in suggestions"
                                :key="suggestion.id"
                                @mousedown.prevent="selectProduct(suggestion)"
                                class="px-2 py-1 hover:bg-gray-300 cursor-pointer"
                            >
                                {{ suggestion.name }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-if="form.items.length">
                    <label class="block mb-1 mt-4">Productos agregados</label>
                    <div class="grid grid-cols-6 gap-2 mb-2 font-bold">
                        <span>Nombre</span>
                        <span>Cantidad</span>
                        <span>Precio unitario</span>
                        <span>Subtotal</span>
                        <span></span>
                    </div>
                    <div
                        v-for="(item, idx) in form.items"
                        :key="item.product_id"
                        class="grid grid-cols-6 gap-2 mb-2 items-center"
                    >
                        <span class="truncate">{{ item.name }}</span>
                        <input v-model.number="item.quantity" type="number" min="0.1" step="0.01" class="border rounded px-2 py-1 w-20" required />
                        <input :value="item.price.toFixed(2)" type="number" class="border rounded px-2 py-1 w-24 text-right" readonly />
                        <span class="border rounded px-2 py-1 w-24 text-right">
                            {{ (item.quantity * item.price).toFixed(2) }}
                        </span>
                        <Button type="button" size="sm" class="bg-red-500 text-white" @click="removeItem(idx)">Quitar</Button>
                    </div>
                </div>
                <div>
                    <label class="block mb-1">Total</label>
                    <input
                      :value="form.items.reduce((sum, item) => sum + (item.quantity * item.price), 0).toFixed(2)"
                      type="number"
                      class="w-full border rounded px-2 py-1"
                      readonly
                    />
                </div>
                <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Guardar venta</Button>
                <Link href="/sales" class="ml-4 text-indigo-600 hover:underline">Cancelar</Link>
            </form>
        </div>
    </AppLayout>
</template>