<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{ user: any }>();

const form = ref({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.role,
});

function submit() {
    router.put(`/users/${props.user.id}`, form.value);
}
</script>

<template>
    <Head title="Editar usuario" />
    <AppLayout>
        <div class="max-w-xl mx-auto p-6 rounded-xl shadow">
            <h1 class="text-2xl font-bold mb-4">Editar usuario</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1">Nombre</label>
                    <input v-model="form.name" type="text" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Correo</label>
                    <input v-model="form.email" type="email" class="w-full border rounded px-2 py-1" required />
                </div>
                <div>
                    <label class="block mb-1">Contraseña (dejar en blanco para no cambiar)</label>
                    <input v-model="form.password" type="password" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="block mb-1">Confirmar contraseña</label>
                    <input v-model="form.password_confirmation" type="password" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="block mb-1">Rol</label>
                    <select v-model="form.role" class="w-full border rounded px-2 py-1">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <Button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-700">Actualizar</Button>
                    <Link href="/users" class="inline-flex items-center px-4 py-2 border rounded text-indigo-600 hover:underline">Cancelar</Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>