<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const props = defineProps<{ purchases: any[] }>();
</script>

<template>
    <Head title="Compras" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-2xl font-bold">Compras</h1>
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/purchases/create">Nueva compra</Link>
                </Button>
            </div>
            <Table>
                <TableCaption class="py-4">Lista de compras</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead>Fecha</TableHead>
                        <TableHead>Total</TableHead>
                        <TableHead>Usuario</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="purchase in props.purchases" :key="purchase.id">
                        <TableCell>{{ purchase.id }}</TableCell>
                        <TableCell>{{ purchase.date }}</TableCell>
                        <TableCell>${{ purchase.total }}</TableCell>
                        <TableCell>{{ purchase.user?.name }}</TableCell>
                        <TableCell>
                            <Button as-child size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                <Link :href="`/purchases/${purchase.id}`">Ver</Link>
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>