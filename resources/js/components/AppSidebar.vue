<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, CalendarCheck, Folder, LayoutGrid, Users, ChevronsUpDown, PlusCircle, ListFilter, Home, ShoppingCart, Video } from 'lucide-vue-next';
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
    // Services Management
    {
        title: 'Services Management',
        href: route('admin.services.index'),
        icon: ShoppingCart,
    },
    {
        title: 'Reservation System',
        href: route('admin.reservations.index'),
        icon: CalendarCheck,
    },
    {
        title: 'User Management',
        href: route('admin.users.index'),
        icon: Users,
    },
    {
        title: 'Livestream',
        href: route('admin.livestreams.create'),
        icon: Video,
    },
    {
        title: 'Notifications',
        href: route('admin.notifications.create'),
        icon: Bell,
    }
];

// Client navigation items
const clientNavItems: NavItem[] = [
    {
        title: 'Home',
        href: dashboard(),
        icon: Home,
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
    {
        title: 'Livestream',
        href: route('livestream'),
        icon: Video,
    },
];

// Staff navigation items (limited management access)
const staffNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: route('staff.dashboard'),
    icon: LayoutGrid,
  },
    {
        title: 'Room Management',
        href: route('staff.rooms.index'),
        icon: BookOpen,
    },
    {
        title: 'Services Management',
        href: route('staff.services.index'),
        icon: ShoppingCart,
    },
    {
        title: 'Reservation System',
        href: route('staff.reservations.index'),
        icon: CalendarCheck,
    },
];

// Determine which navigation items to show based on user role
const mainNavItems = user.role === 'admin' ? adminNavItems : (user.role === 'staff' ? staffNavItems : clientNavItems);

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
