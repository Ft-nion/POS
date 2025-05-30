<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    cashRegister: {
        id: number,
        opening_amount: number,
        closing_amount: number|null,
        opened_at: string,
        closed_at: string|null,
    }
}>();

const form = ref({
    closing_amount: props.cashRegister.closing_amount ?? '',
});

function submit() {
    router.put(`/cash_registers/${props.cashRegister.id}`, form.value);
}
</script>

<template>
    <Head :title="`Cerrar caja #${props.cashRegister.id}`" />
    <AppLayout>
        <div class="max-w-xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Cerrar caja #{{ props.cashRegister.id }}</h1>
            <!-- Solo botón para cerrar -->
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Monto final (calculado):</label>
                    <input
                        :value="Number(props.cashRegister.opening_amount) + (props.cashRegister.sales?.reduce((sum, sale) => sum + Number(sale.total), 0) || 0)"
                        type="number"
                        class="w-full border rounded px-2 py-1"
                        readonly
                    />
                </div>
                <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Cerrar caja</Button>
                <Link href="/cash_registers" class="ml-4 text-indigo-600 hover:underline">Cancelar</Link>
            </form>
        </div>
    </AppLayout>
</template>