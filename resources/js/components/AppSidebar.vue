<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, CalendarCheck, Folder, LayoutGrid, Users, ChevronsUpDown, PlusCircle, ListFilter, Home, ShoppingCart } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { route } from 'ziggy-js';

const page = usePage();
const user = page.props.auth.user;

// Admin navigation items
const adminNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    // Event Management with dropdown
    {
        title: 'Event Management',
        href: '#',
        icon: Calendar,
        hasDropdown: true,
        dropdownItems: [
            {
                title: 'All Events',
                href: route('admin.events.index'),
                icon: ListFilter,
            },
            {
                title: 'Create Event',
                href: route('admin.events.create'),
                icon: PlusCircle,
            },
            {
                title: 'Calendar View',
                href: route('admin.events.calendar'),
                icon: Calendar,
            },
        ],
    },
    // Room Management - simplified
    {
        title: 'Room Management',
        href: route('admin.rooms.index'),
        icon: BookOpen,
    },
    {
        title: 'Reservation System',
        href: '/reservations',
        icon: CalendarCheck,
    },
    {
        title: 'Notification System',
        href: '/notifications',
        icon: Bell,
    },
    {
        title: 'User Management',
        href: '/users',
        icon: Users,
    },
];

// Client navigation items
const clientNavItems: NavItem[] = [
    {
        title: 'Home',
        href: dashboard(),
        icon: Home,
    },
    {
        title: 'Events',
        href: route('client.events'),
        icon: Calendar,
    },
    {
        title: 'My Reservations',
        href: route('client.reservations'),
        icon: CalendarCheck,
    },
    {
        title: 'Book a Room',
        href: route('client.book'),
        icon: ShoppingCart,
    },
    {
        title: 'Notifications',
        href: route('client.notifications'),
        icon: Bell,
    },
];

// Determine which navigation items to show based on user role
const mainNavItems = user.role === 'admin' ? adminNavItems : clientNavItems;

const footerNavItems: NavItem[] = [
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
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
