<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Sale } from '@/types';

const props = defineProps<{ sale: Sale }>();
</script>

<template>
    <Head title="Detalle de venta" />
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Detalle de venta #{{ props.sale.id }}</h1>
            <div class="mb-4">
                <p><strong>Fecha:</strong> {{ props.sale.date }}</p>
                <p><strong>Vendedor:</strong> {{ props.sale.user?.name }}</p>
                <p><strong>Total:</strong> ${{ props.sale.total }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Productos vendidos</h2>
                <table class="w-full border rounded mb-4">
                    <thead>
                        <tr>
                            <th class="p-2">Producto</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Precio unitario</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in props.sale.items" :key="item.id">
                            <td class="p-2">{{ item.product?.name }}</td>
                            <td class="p-2">{{ item.quantity }}</td>
                            <td class="p-2">${{ item.price }}</td>
                            <td class="p-2">${{ (item.quantity * item.price).toFixed(2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Button as-child class="bg-indigo-500 text-white hover:bg-indigo-700">
                <Link href="/sales">Volver a ventas</Link>
            </Button>
        </div>
    </AppLayout>
</template>