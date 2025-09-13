import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    hasDropdown?: boolean;
    dropdownItems?: NavItem[];
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role?: 'client' | 'staff' | 'admin';
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Reservation {
    reservation_id: number;
    user_id: number;
    service_id: number;
    date_reserved: string;
    time_start: string;
    time_end: string;
    status: 'Pending' | 'Approved' | 'Cancelled';
    remarks?: string;
    service_name?: string;
}
