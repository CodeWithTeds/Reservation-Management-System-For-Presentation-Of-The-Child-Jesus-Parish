<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, CalendarCheck, Folder, LayoutGrid, Users, ChevronsUpDown, PlusCircle, ListFilter } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { route } from 'ziggy-js';

const mainNavItems: NavItem[] = [
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

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
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
