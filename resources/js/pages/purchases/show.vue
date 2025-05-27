<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{ purchase: any }>();
</script>

<template>
    <Head title="Detalle de compra" />
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Detalle de compra #{{ props.purchase.id }}</h1>
            <div class="mb-4">
                <p><strong>Fecha:</strong> {{ props.purchase.date }}</p>
                <p><strong>Usuario:</strong> {{ props.purchase.user?.name }}</p>
                <p><strong>Total:</strong> ${{ props.purchase.total }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Productos comprados</h2>
                <table class="w-full border rounded mb-4">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-2">Producto</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Precio compra</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in props.purchase.details" :key="item.id">
                            <td class="p-2">{{ item.product?.name }}</td>
                            <td class="p-2">{{ item.quantity }}</td>
                            <td class="p-2">${{ item.purchase_price }}</td>
                            <td class="p-2">${{ (item.quantity * item.purchase_price).toFixed(2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Button as-child class="bg-indigo-500 text-white hover:bg-indigo-700">
                <Link href="/purchases">Volver a compras</Link>
            </Button>
        </div>
    </AppLayout>
</template>