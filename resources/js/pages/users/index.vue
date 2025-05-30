<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Pencil, Trash, UserPlus } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { computed } from 'vue';

const props = defineProps<{ users: any[] }>();
const users = computed(() => props.users);

function deleteUser(id: number) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        router.delete(`/users/${id}`);
    }
}
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-2xl font-bold">Usuarios</h1>
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/users/create"><UserPlus class="mr-1" /> Nuevo usuario</Link>
                </Button>
            </div>
            <div class="flex items-center justify-between">
                <Table>
                    <TableCaption class="py-1">Lista de usuarios</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Correo</TableHead>
                            <TableHead>Rol</TableHead>
                            <TableHead class="text-center w-64">Acciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users" :key="user.id">
                            <TableCell>{{ user.id }}</TableCell>
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell class="capitalize">{{ user.role }}</TableCell>
                            <TableCell class="text-center w-64 flex justify-center gap-10">
                                <Button size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Link :href="`/users/${user.id}/edit`">
                                        <Pencil />
                                    </Link>
                                </Button>
                                <Button
                                    size="sm"
                                    class="bg-red-500 text-white hover:bg-red-700"
                                    @click="deleteUser(user.id)"
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