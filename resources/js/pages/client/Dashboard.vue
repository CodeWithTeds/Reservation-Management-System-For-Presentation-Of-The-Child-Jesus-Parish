<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Client Dashboard" />
    <AppLayout>
        <div class="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Client Dashboard</h1>
            <p class="mt-4 text-gray-600 dark:text-gray-300">
                Welcome to your client dashboard. Here you can manage your reservations and bookings.
            </p>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">My Upcoming Reservations</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">View and manage your upcoming reservations.</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Available Rooms</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Browse available rooms for booking.</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Notifications</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Check your latest notifications and updates.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>