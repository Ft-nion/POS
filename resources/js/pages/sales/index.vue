<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Sale, type SharedData } from '@/types';
import { computed } from 'vue';

interface SalesPageProps extends SharedData {
    sales: Sale[];
}

const props = defineProps<SalesPageProps>();
const sales = computed(() => props.sales);
</script>

<template>
    <Head title="Ventas" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-2xl font-bold">Ventas</h1>
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/sales/create">Nueva venta</Link>
                </Button>
            </div>
            <Table>
                <TableCaption class="py-4">Lista de ventas</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead>Fecha</TableHead>
                        <TableHead>Total</TableHead>
                        <TableHead>Vendedor</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="sale in sales" :key="sale.id">
                        <TableCell>{{ sale.id }}</TableCell>
                        <TableCell>{{ sale.date }}</TableCell>
                        <TableCell>${{ sale.total }}</TableCell>
                        <TableCell>{{ sale.user?.name }}</TableCell>
                        <TableCell>
                            <Button as-child size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                <Link :href="`/sales/${sale.id}`">Ver</Link>
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>