<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    cashRegister: {
        id: number,
        user: { name: string },
        opening_amount: number,
        closing_amount: number|null,
        opened_at: string,
        closed_at: string|null,
        sales?: Array<{
            id: number,
            date: string,
            total: number,
        }>
    }
}>();
</script>

<template>
    <Head :title="`Caja #${props.cashRegister.id}`" />
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Caja #{{ props.cashRegister.id }}</h1>
            <div class="mb-6 space-y-2">
                <div><strong>Usuario:</strong> {{ props.cashRegister.user?.name }}</div>
                <div><strong>Monto inicial:</strong> ${{ props.cashRegister.opening_amount }}</div>
                <div>
                    <strong>Monto final:</strong>
                    <span v-if="props.cashRegister.closing_amount !== null">${{ props.cashRegister.closing_amount }}</span>
                    <span v-else class="text-gray-400">-</span>
                </div>
                <div><strong>Abierta:</strong> {{ props.cashRegister.opened_at }}</div>
                <div>
                    <strong>Cerrada:</strong>
                    <span v-if="props.cashRegister.closed_at">{{ props.cashRegister.closed_at }}</span>
                    <span v-else class="text-green-600 font-bold">Abierta</span>
                </div>
            </div>

            <div v-if="props.cashRegister.sales && props.cashRegister.sales.length">
                <h2 class="text-xl font-semibold mb-2">Ventas asociadas</h2>
                <table class="w-full border rounded mb-4">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">ID</th>
                            <th class="px-2 py-1">Fecha</th>
                            <th class="px-2 py-1">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in props.cashRegister.sales" :key="sale.id">
                            <td class="px-2 py-1">{{ sale.id }}</td>
                            <td class="px-2 py-1">{{ sale.date }}</td>
                            <td class="px-2 py-1">${{ sale.total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="!props.cashRegister.closed_at" class="mb-4">
                <Button as-child class="bg-red-600 text-white hover:bg-red-800">
                    <Link :href="`/cash_registers/${props.cashRegister.id}/edit`">
                        Cerrar caja
                    </Link>
                </Button>
            </div>

            <div class="mt-4">
                <Link href="/cash_registers" class="text-indigo-600 hover:underline">Volver a cajas</Link>
            </div>
        </div>
    </AppLayout>
</template>