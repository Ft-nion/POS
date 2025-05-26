<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

const form = ref({
    name: '',
    barcode: '',
    purchase_price: '',
    sale_price: '',
    stock: '',
    unit: '',
});

function submit() {
    router.post('/products', form.value);
}
</script>

<template>
    <Head title="Crear producto" />
    <AppLayout>
        <div class="max-w-xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Crear producto</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Nombre</label>
                    <input v-model="form.name" type="text" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Código de barras</label>
                    <input v-model="form.barcode" type="text" class="w-full border rounded px-2 py-1"/>
                </div>
                <div>
                    <label class="block mb-1">Precio de compra</label>
                    <input v-model="form.purchase_price" type="number" step="0.01" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Precio de venta</label>
                    <input v-model="form.sale_price" type="number" step="0.01" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Stock</label>
                    <input v-model="form.stock" type="number" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Unidad</label>
                    <input v-model="form.unit" type="text" class="w-full border rounded px-2 py-1" />
                </div>
                <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Guardar</Button>
                <Link href="/products" class="ml-4 text-indigo-600 hover:underline">Cancelar</Link>
            </form>
        </div>
    </AppLayout>
</template>