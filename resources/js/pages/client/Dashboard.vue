<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

type UpcomingItem = {
  reservation_id: number|string
  service_name: string|null
  date_reserved: string|null
  time_start: string|null
  time_end: string|null
  status: string
}

type Stats = {
  total: number
  pending: number
  approved: number
  cancelled: number
}

const page = usePage();
const stats = computed<Stats>(() => (page.props.stats as Stats) ?? { total: 0, pending: 0, approved: 0, cancelled: 0 });
const upcoming = computed<UpcomingItem[]>(() => (page.props.upcoming as UpcomingItem[]) ?? []);
const userName = computed<string>(() => ((page.props.auth as any)?.user?.name) ?? 'Client');
</script>

<template>
  <Head title="Client Dashboard" />
  <AppLayout>
    <div class="w-full p-4 sm:p-6 lg:p-8 space-y-8">
      <!-- Hero Header -->
      <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#0033A0] via-[#0042BF] to-[#0056D6] p-6 sm:p-8 text-white shadow-lg">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-sm/6 opacity-90">Welcome back</p>
            <h1 class="mt-1 text-2xl sm:text-3xl font-semibold">{{ userName }}</h1>
            <p class="mt-2 text-sm sm:text-base opacity-85">Here’s an overview of your reservations and activity.</p>
            <div class="mt-4 flex flex-wrap gap-3">
              <Link :href="route('client.reservations')" class="inline-flex items-center gap-2 rounded-md bg-white/15 px-3 py-2 text-sm font-semibold text-white backdrop-blur-sm ring-1 ring-white/30 hover:bg-white/25 hover:ring-white/50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>
                Manage Reservations
              </Link>
              <Link :href="route('client.notifications')" class="inline-flex items-center gap-2 rounded-md bg-white/15 px-3 py-2 text-sm font-semibold text-white backdrop-blur-sm ring-1 ring-white/30 hover:bg-white/25 hover:ring-white/50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9V5.25m-4.5 3.75V5.25M5.25 9A2.25 2.25 0 013 6.75V6a3 3 0 013-3h12a3 3 0 013 3v.75A2.25 2.25 0 0118.75 9m-13.5 0h13.5M5.25 9V19.5A2.25 2.25 0 007.5 21.75h9A2.25 2.25 0 0018.75 19.5V9" />
                </svg>
                Notifications
              </Link>
            </div>
          </div>
          <div class="hidden sm:block">
            <div class="h-16 w-16 rounded-xl bg-white/20 ring-1 ring-white/30 backdrop-blur-sm flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 opacity-90">
                <path d="M11.25 3a.75.75 0 01.75-.75h8.25a.75.75 0 01.75.75v8.25a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V3z" />
                <path d="M3 12a.75.75 0 01.75-.75h8.25a.75.75 0 01.75.75v8.25a.75.75 0 01-.75.75H3.75A.75.75 0 013 20.25V12z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Reservations</div>
            <div class="rounded-md bg-indigo-50 p-2 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-300">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M5.25 3A2.25 2.25 0 003 5.25v13.5A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V5.25A2.25 2.25 0 0018.75 3H5.25z" />
              </svg>
            </div>
          </div>
          <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ stats.total }}</div>
        </div>
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
            <div class="rounded-md bg-amber-50 p-2 text-amber-600 dark:bg-amber-900/30 dark:text-amber-300">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M12 2.25c5.385 0 9.75 4.365 9.75 9.75s-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25z" />
              </svg>
            </div>
          </div>
          <div class="mt-2 text-3xl font-semibold text-amber-600 dark:text-amber-400">{{ stats.pending }}</div>
        </div>
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">Approved</div>
            <div class="rounded-md bg-emerald-50 p-2 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-300">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M9 12.75l2.25 2.25L15 10.5" />
              </svg>
            </div>
          </div>
          <div class="mt-2 text-3xl font-semibold text-emerald-600 dark:text-emerald-400">{{ stats.approved }}</div>
        </div>
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">Cancelled</div>
            <div class="rounded-md bg-rose-50 p-2 text-rose-600 dark:bg-rose-900/30 dark:text-rose-300">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M6.75 6.75l10.5 10.5M17.25 6.75L6.75 17.25" />
              </svg>
            </div>
          </div>
          <div class="mt-2 text-3xl font-semibold text-rose-600 dark:text-rose-400">{{ stats.cancelled }}</div>
        </div>
      </div>

      <!-- Upcoming -->
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <h2 class="text-lg font-medium text-gray-900 dark:text-white">Upcoming Reservations</h2>
          <div v-if="upcoming.length === 0" class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            You have no upcoming reservations.
          </div>
          <ul v-else class="mt-4 divide-y divide-gray-200 dark:divide-gray-700">
            <li v-for="item in upcoming" :key="item.reservation_id" class="py-4">
              <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                  <div class="text-base font-medium text-gray-900 dark:text-white truncate">{{ item.service_name || 'Service' }}</div>
                  <div class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                    {{ item.date_reserved }} • {{ item.time_start }} - {{ item.time_end }}
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="rounded-full px-2.5 py-1 text-xs font-medium"
                    :class="{
                      'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300': item.status === 'Approved',
                      'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300': item.status === 'Pending',
                      'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300': item.status === 'Cancelled',
                      'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300': !['Approved','Pending','Cancelled'].includes(item.status)
                    }">
                    {{ item.status }}
                  </span>
                  <Link :href="route('client.reservations')" class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                    View
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5">
                      <path d="M9 5.25l6 6-6 6" />
                    </svg>
                  </Link>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <h2 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h2>
          <div class="mt-4 grid grid-cols-1 gap-3">
            <Link :href="route('client.reservations')" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0033A0] px-3 py-2 text-sm font-semibold text-white shadow hover:bg-[#002B80] focus:outline-none focus:ring-2 focus:ring-[#0033A0]">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                <path d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
              </svg>
              Manage Reservations
            </Link>
            <Link :href="route('client.notifications')" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                <path d="M12 22.5a3 3 0 003-3H9a3 3 0 003 3z" />
                <path d="M18 8a6 6 0 10-12 0v5.25l-1.5 1.5v.75h15v-.75l-1.5-1.5V8z" />
              </svg>
              See Notifications
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>