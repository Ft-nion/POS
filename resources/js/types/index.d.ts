import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Employee  {
    id: number;
    name: string;
    email: string;
    position: string;
    salary: number;
}

export interface Product {
    id: number;
    name: string;
    barcode: string;
    description: string;
    sale_price: number;
    stock: number;
    status: boolean;
    unit?: string | null;
}

export interface SaleItem {
    id: number;
    sale_id: number;
    product_id: number;
    quantity: number;
    price: number;
    subtotal: number;
    product?: Product; // Relación opcional para mostrar info del producto
}

export interface Sale {
    id: number;
    date: string;
    total: number;
    user_id: number;
    created_at: string;
    updated_at: string;
    items?: SaleItem[]; // Relación opcional para mostrar los items de la venta
}

export interface PurchaseItem {
    id: number;
    purchase_id: number;
    product_id: number;
    quantity: number;
    price: number;
    subtotal: number;
    product?: Product; // Relación opcional para mostrar info del producto
}
export interface Purchase {
    id: number;
    date: string;
    total: number;
    user_id: number;
    created_at: string;
    updated_at: string;
    items?: PurchaseItem[]; // Relación opcional para mostrar los items de la compra
}
