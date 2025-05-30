<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { UsersRound } from 'lucide-vue-next';
import { CupSoda } from 'lucide-vue-next';

const user = usePage().props.auth?.user;

const mainNavItems: NavItem[] = [
    {
        title: 'Panel',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Ventas',
        href: '/sales',
        icon: BookOpen,
    },
    {
        title: 'Compras',
        href: '/purchases',
        icon: Folder,
    },
    {
        title: 'Caja',
        href: '/cash_registers',
        icon: CupSoda,
    }
];

// Solo admin ve los módulos Usuarios y Productos
if (user && user.role === 'admin') {
    mainNavItems.push(
        {
            title: 'Usuarios',
            href: '/users',
            icon: UsersRound,
        },
        {
            title: 'Productos',
            href: '/products',
            icon: CupSoda,
        }
    );
}

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        
        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
