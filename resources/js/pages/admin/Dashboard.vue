<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <a href="route('admin.events.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">📅</div>
                    <h3 class="text-lg font-semibold">Event Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Manage events and schedules</p>
                </a>
                <a href="route('admin.rooms.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">🏠</div>
                    <h3 class="text-lg font-semibold">Room Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Manage rooms and facilities</p>
                </a>
                <a href="route('admin.services.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">✨</div>
                    <h3 class="text-lg font-semibold">Service Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Manage services and offerings</p>
                </a>
            </div>
            <div class="relative min-h-[50vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-white dark:bg-gray-800 p-6">
                <h2 class="text-xl font-bold mb-4">Welcome to Admin Dashboard</h2>
                <p class="mb-4">From here you can manage all aspects of the reservation system:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Manage events and schedules</li>
                    <li>Configure rooms and facilities</li>
                    <li>Set up services like Hall rentals, Baptism, Wedding, etc.</li>
                    <li>View and manage user reservations</li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
