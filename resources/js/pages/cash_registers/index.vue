<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const props = defineProps<{
    cashRegisters: Array<{
        id: number,
        user: { name: string },
        opening_amount: number,
        closing_amount: number|null,
        opened_at: string,
        closed_at: string|null,
    }>
}>();
</script>

<template>
    <Head title="Cajas" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-2xl font-bold">Cajas</h1>
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/cash_registers/create">Abrir caja</Link>
                </Button>
            </div>
            <div class="flex items-center justify-between">
                <Table>
                    <TableCaption class="py-1">Lista de cajas</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Usuario</TableHead>
                            <TableHead>Monto inicial</TableHead>
                            <TableHead>Monto final</TableHead>
                            <TableHead>Abierta</TableHead>
                            <TableHead>Cerrada</TableHead>
                            <TableHead class="text-center w-64">Acciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="caja in props.cashRegisters" :key="caja.id">
                            <TableCell>{{ caja.id }}</TableCell>
                            <TableCell>{{ caja.user?.name }}</TableCell>
                            <TableCell>${{ caja.opening_amount }}</TableCell>
                            <TableCell>
                                <span v-if="caja.closing_amount !== null">${{ caja.closing_amount }}</span>
                                <span v-else class="text-gray-400">-</span>
                            </TableCell>
                            <TableCell>{{ caja.opened_at }}</TableCell>
                            <TableCell>
                                <span v-if="caja.closed_at">{{ caja.closed_at }}</span>
                                <span v-else class="text-green-600 font-bold">Abierta</span>
                            </TableCell>
                            <TableCell class="text-center w-64 flex justify-center gap-10">
                                <Button size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Link :href="`/cash_registers/${caja.id}`">
                                        Ver
                                    </Link>
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>