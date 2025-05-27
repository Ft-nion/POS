<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

const form = ref({
    opening_amount: '',
});

function submit() {
    router.post('/cash_registers', form.value);
}
</script>

<template>
    <Head title="Abrir caja" />
    <AppLayout>
        <div class="max-w-xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Abrir caja</h1>
            <div v-if="$page.props.flash && $page.props.flash.error" class="mb-4 p-2 bg-red-100 text-red-700 rounded">
                {{ $page.props.flash.error }}
            </div>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Monto inicial</label>
                    <input
                        v-model="form.opening_amount"
                        type="number"
                        min="0"
                        step="0.01"
                        class="w-full border rounded px-2 py-1"
                        required
                    />
                </div>
                <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Abrir caja</Button>
                <Link href="/cash_registers" class="ml-4 text-indigo-600 hover:underline">Cancelar</Link>
            </form>
        </div>
    </AppLayout>
</template>