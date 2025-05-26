<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Pencil, CirclePlus, Trash } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Employee, type SharedData } from '@/types';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { computed } from 'vue';


interface EmployeePageProps extends SharedData {
    employees: Employee[];
    }


interface EmployeePageProps {
    employees: Employee[];
}

const props = defineProps<EmployeePageProps>();
const employees = computed(() => props.employees);
</script>

<template>
    <Head title="Empleados" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex">
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700" type="button">
                    <Link href="/employees/create"> <CirclePlus /> Crear</Link>
                </Button>
            </div>

            <div class="flex items-center justify-between ">
                <Table>
                    <TableCaption class="py-4">Lista de empleados</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Correo</TableHead>
                            <TableHead>Posición</TableHead>
                            <TableHead>Salario</TableHead>
                            <TableHead class="text-center w-64">Acciones</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow v-for="employee in employees" :key="employee.id">
                            <TableCell>{{ employee.name }}</TableCell>
                            <TableCell>{{ employee.email }}</TableCell>
                            <TableCell>{{ employee.position }}</TableCell>
                            <TableCell>{{ employee.salary }}</TableCell>
                            <TableCell class="text-center w-64 flex justify-center gap-10">
                                <Button size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Pencil />
                                </Button>
                                <Button size="sm" class="bg-red-500 text-white hover:bg-red-700">
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