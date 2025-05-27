<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Pencil, CirclePlus, Trash } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Product, type SharedData } from '@/types';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { computed, ref } from 'vue';

interface ProductPageProps extends SharedData {
    products: Product[];
    filters?: {
        search?: string;
    };
}

const props = defineProps<ProductPageProps>();
const products = computed(() => props.products);

// Barra de búsqueda
const search = ref(props.filters?.search ?? '');

function searchProducts() {
    router.get('/products', { search: search.value }, { preserveState: true, replace: true });
}

function deleteProduct(id: number) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        router.delete(`/products/${id}`);
    }
}

function clearSearch() {
    search.value = '';
    searchProducts();
}

const csrf = usePage().props.csrf_token;
</script>
<template>
    <Head title="Productos" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center mb-2">
                <form @submit.prevent="searchProducts" class="flex gap-2">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Buscar por nombre..."
                        class="border rounded px-2 py-1"
                    />
                    <Button type="submit" size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700">Buscar</Button>
                    <Button
                        type="button"
                        size="sm"
                        class="bg-gray-300 text-gray-700 hover:bg-gray-400"
                        @click="clearSearch"
                        v-if="search"
                    >
                        Limpiar
                    </Button>
                </form>
            </div>

            <div class="flex justify-between items-center mb-2">
                <div class="flex gap-2">
                    <Button as-child size="sm" class="bg-green-600 text-white hover:bg-green-800">
                        <a href="/export">Exportar Excel</a>
                    </Button>
                    <form action="/import" method="POST" enctype="multipart/form-data" class="inline">
                        <input type="file" name="file" accept=".xlsx,.xls" class="inline-block" required />
                        <Button type="submit" size="sm" class="bg-blue-600 text-white hover:bg-blue-800 ml-2">Importar Excel</Button>
                    </form>
                </div>
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/products/create"> <CirclePlus /> Crear</Link>
                </Button>
            </div>

            <div class="flex items-center justify-between ">
                <Table>
                    <TableCaption class="py-4">Lista de productos</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Descripción</TableHead>
                            <TableHead>Unidad</TableHead>
                            <TableHead>Precio venta</TableHead>
                            <TableHead>Estado</TableHead>
                            <TableHead>Stock</TableHead>
                            <TableHead class="text-center w-64">Acciones</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow v-for="product in products" :key="product.id">
                            <TableCell>{{ product.name }}</TableCell>
                            <TableCell>{{ product.description }}</TableCell>
                            <TableCell>{{ product.unit }}</TableCell>
                            <TableCell>${{ product.sale_price }}</TableCell>
                            <TableCell>
                                <span v-if="product.status" class="text-green-600 font-semibold">Activo</span>
                                <span v-else class="text-red-600 font-semibold">Inactivo</span>
                            </TableCell>
                            <TableCell>
                                {{ product.stock }}
                            </TableCell>
                            <TableCell class="text-center w-64 flex justify-center gap-10">
                                <Button size="sm" 
                                    class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Link :href="`/products/${product.id}/edit`">
                                        <Pencil />
                                    </Link>
                                </Button>
                                <Button
                                    size="sm"
                                    class="bg-red-500 text-white hover:bg-red-700"
                                    @click="deleteProduct(product.id)"
                                >
                                    <Trash />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>