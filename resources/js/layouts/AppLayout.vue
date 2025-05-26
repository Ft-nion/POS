<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { usePage } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <div v-if="page.props.flash?.success" class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ page.props.flash.success }}
            </div>
            <slot />
        </div>
    </AppLayout>
</template>
