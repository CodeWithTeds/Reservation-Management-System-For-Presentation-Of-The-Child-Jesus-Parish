<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { route } from 'ziggy-js';
import BarChart from '@/components/charts/BarChart.vue';
import PieChart from '@/components/charts/PieChart.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { computed } from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    stats: {
        reservations: {
            total: number;
            pending: number;
            approved: number;
            cancelled: number;
        };
        events: {
            total: number;
            upcoming: number;
            completed: number;
        };
        rooms: {
            total: number;
            available: number;
            occupied: number;
        };
        services: {
            total: number;
        };
        users: {
            total: number;
        };
    };
    charts: {
        monthlyReservations: {
            labels: string[];
            data: number[];
        };
        serviceDistribution: {
            labels: string[];
            data: number[];
        };
        roomUsage: {
            labels: string[];
            data: number[];
        };
    };
}>();

// Landing page palette
const PALETTE = {
  blue: '#0033A0',
  yellow: '#FFD633',
  dark: '#333333',
} as const

// Helper to repeat colors to match dataset length
const makeArray = (colors: string[], length: number) => Array.from({ length }, (_, i) => colors[i % colors.length])

// Chart color sets derived from landing page palette
const monthlyBg = computed<string[]>(() => makeArray(['rgba(0, 51, 160, 0.5)'], props.charts.monthlyReservations.data.length))
const monthlyBorder = computed<string[]>(() => makeArray([PALETTE.blue], props.charts.monthlyReservations.data.length))

const serviceBg = computed<string[]>(() => makeArray([PALETTE.yellow, PALETTE.blue, PALETTE.dark], props.charts.serviceDistribution.data.length))
const serviceBorder = computed<string[]>(() => makeArray([PALETTE.dark], props.charts.serviceDistribution.data.length))

const roomBg = computed<string[]>(() => makeArray(['rgba(0, 51, 160, 0.5)', 'rgba(255, 214, 51, 0.5)'], props.charts.roomUsage.data.length))
const roomBorder = computed<string[]>(() => makeArray([PALETTE.blue, PALETTE.yellow], props.charts.roomUsage.data.length))
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Stats Cards -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <a :href="route('admin.reservations.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">📅</div>
                    <h3 class="text-lg font-semibold">Reservation Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Approve or cancel reservations</p>
                    <div class="mt-2 text-sm font-medium">Total: {{ stats.reservations.total }}</div>
                </a>
                <a :href="route('admin.rooms.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">🏠</div>
                    <h3 class="text-lg font-semibold">Room Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Manage rooms and facilities</p>
                    <div class="mt-2 text-sm font-medium">Total: {{ stats.rooms.total }}</div>
                </a>
                <a :href="route('admin.services.index')" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow">
                    <div class="text-3xl mb-2">✨</div>
                    <h3 class="text-lg font-semibold">Service Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Manage services and offerings</p>
                    <div class="mt-2 text-sm font-medium">Total: {{ stats.services.total }}</div>
                </a>
            </div>
            
            <!-- Stats Summary -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium">Reservations</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.reservations.total }}</div>
                        <div class="mt-2 grid grid-cols-3 gap-2 text-xs">
                            <div class="flex flex-col">
                                <span class="text-green-500 font-medium">{{ stats.reservations.approved }}</span>
                                <span class="text-gray-500">Approved</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-yellow-500 font-medium">{{ stats.reservations.pending }}</span>
                                <span class="text-gray-500">Pending</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-red-500 font-medium">{{ stats.reservations.cancelled }}</span>
                                <span class="text-gray-500">Cancelled</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium">Events</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.events.total }}</div>
                        <div class="mt-2 grid grid-cols-2 gap-2 text-xs">
                            <div class="flex flex-col">
                                <span class="text-blue-500 font-medium">{{ stats.events.upcoming }}</span>
                                <span class="text-gray-500">Upcoming</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-green-500 font-medium">{{ stats.events.completed }}</span>
                                <span class="text-gray-500">Completed</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium">Rooms</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.rooms.total }}</div>
                        <div class="mt-2 grid grid-cols-2 gap-2 text-xs">
                            <div class="flex flex-col">
                                <span class="text-green-500 font-medium">{{ stats.rooms.available }}</span>
                                <span class="text-gray-500">Available</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-orange-500 font-medium">{{ stats.rooms.occupied }}</span>
                                <span class="text-gray-500">Occupied</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium">Users</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.users.total }}</div>
                        <p class="text-xs text-gray-500 mt-2">Registered clients</p>
                    </CardContent>
                </Card>
            </div>
            
            <!-- Charts -->
            <div class="grid gap-4 md:grid-cols-2">
                <Card class="col-span-2">
                    <CardHeader>
                        <CardTitle>Monthly Reservations</CardTitle>
                        <CardDescription>Reservation trends over the current year</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="h-80">
                            <BarChart 
                                :chart-data="charts.monthlyReservations" 
                                chart-id="monthly-reservations"
                                :height="300"
                                :bg-color="monthlyBg"
                                :border-color="monthlyBorder"
                            />
                        </div>
                    </CardContent>
                </Card>
                
                <Card>
                    <CardHeader>
                        <CardTitle>Service Distribution</CardTitle>
                        <CardDescription>Reservations by service type</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="h-80">
                            <PieChart 
                                :chart-data="charts.serviceDistribution" 
                                chart-id="service-distribution"
                                :height="300"
                                :bg-color="serviceBg"
                                :border-color="serviceBorder"
                            />
                        </div>
                    </CardContent>
                </Card>
                
                <Card>
                    <CardHeader>
                        <CardTitle>Room Usage</CardTitle>
                        <CardDescription>Events by room</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="h-80">
                            <BarChart 
                                :chart-data="charts.roomUsage" 
                                chart-id="room-usage"
                                :height="300"
                                :bg-color="roomBg"
                                :border-color="roomBorder"
                            />
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
