<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

// Recibe los productos como prop
const props = defineProps<{ products: any[] }>();

const form = ref({
    date: new Date().toISOString().slice(0, 10),
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
            (p.name && p.name.toLowerCase().includes(value)) ||
            (p.barcode && p.barcode.toLowerCase().includes(value))
    );
}

function selectProduct(product: any) {
    type PurchaseItem = {
        product_id: number;
        name: string;
        barcode: string;
        quantity: number;
        purchase_price: number;
        subtotal: number;
    };

    if (!form.value.items) {
        form.value.items = [];
    }

    const existing = (form.value.items as PurchaseItem[]).find(item => item.product_id === product.id);
    if (existing) {
        existing.quantity += 1;
        existing.subtotal = existing.quantity * existing.purchase_price;
    } else {
        (form.value.items as PurchaseItem[]).push({
            product_id: product.id,
            name: product.name,
            barcode: product.barcode,
            quantity: 1,
            purchase_price: product.purchase_price ?? 0, // <-- AQUÍ
            subtotal: product.purchase_price ?? 0,       // <-- AQUÍ
        });
    }
    search.value = '';
    suggestions.value = [];
}

function removeItem(idx: number) {
    form.value.items.splice(idx, 1);
}

function calculateTotal() {
    form.value.total = form.value.items.reduce((sum, item) => sum + (item.quantity * item.purchase_price), 0);
}

function submit() {
    calculateTotal();
    const payload = {
        ...form.value,
        items: form.value.items.map(({ product_id, quantity, purchase_price }) => ({
            product_id, quantity, purchase_price
        }))
    };
    router.post('/purchases', payload);
}
</script>

<template>
    <Head title="Nueva compra" />
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Registrar compra</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Fecha</label>
                    <input v-model="form.date" type="date" class="w-full border rounded px-2 py-1" required />
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
                        <ul v-if="suggestions.length" class="absolute border rounded z-10 w-full max-h-40 overflow-auto">
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
                        <span>Precio compra</span>
                         <span>Subtotal</span>
                        <span></span>
                    </div>
                    <div
                        v-for="(item, idx) in form.items"
                        :key="item.product_id"
                        class="grid grid-cols-6 gap-2 mb-2 items-center"
                    >
                        <span class="truncate">{{ item.name }}</span>
                        <input
                            v-model.number="item.quantity"
                            type="number"
                            min="0.01"
                            step="0.01"
                            class="border rounded px-2 py-1 w-20"
                            required
                            @input="item.subtotal = (item.quantity * item.purchase_price).toFixed(2)"
                        />
                        <input
                            v-model.number="item.purchase_price"
                            type="number"
                            min="0.01"
                            step="0.01"
                            class="border rounded px-2 py-1 w-24 text-right"
                            required
                            @input="item.subtotal = (item.quantity * item.purchase_price).toFixed(2)"
                        />
                        <input
                            v-model.number="item.subtotal"
                            type="number"
                            class="border rounded px-2 py-1 w-24"
                            readonly
                        />
                        <Button type="button" size="sm" class="bg-red-500 text-white" @click="removeItem(idx)">Quitar</Button>
                    </div>
                </div>
                <div>
                    <label class="block mb-1">Total</label>
                    <input
                      :value="form.items.reduce((sum, item) => sum + (item.quantity * item.purchase_price), 0).toFixed(2)"
                      type="number"
                      class="w-full border rounded px-2 py-1"
                      readonly
                    />
                </div>
                <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Guardar compra</Button>
                <Link href="/purchases" class="ml-4 text-indigo-600 hover:underline">Cancelar</Link>
            </form>
        </div>
    </AppLayout>
</template>