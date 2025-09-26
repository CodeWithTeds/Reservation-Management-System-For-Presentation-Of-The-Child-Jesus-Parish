<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

interface NotificationItem {
  id: number;
  title: string;
  message: string;
  created_at: string;
  expires_at?: string | null;
}

const props = defineProps<{ notifications: NotificationItem[] }>();
</script>

<template>
  <Head title="Notifications" />
  <AppLayout>
    <div class="w-full px-4 lg:px-6">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
          <p class="mt-1 text-gray-600 dark:text-gray-300">Latest updates from admins will appear here.</p>
        </div>
      </div>

      <div v-if="props.notifications && props.notifications.length" class="grid grid-cols-1 gap-4">
        <div
          v-for="n in props.notifications"
          :key="n.id"
          class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-0 shadow-sm hover:shadow-md transition-shadow dark:border-gray-700 dark:bg-gray-800"
        >
          <div class="relative flex flex-col md:flex-row">
            <!-- Left content -->
            <div class="flex-1 p-5">
              <div class="flex items-start justify-between gap-3">
                <h2 class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white">{{ n.title }}</h2>
                <span class="shrink-0 text-xs text-gray-500">{{ new Date(n.created_at).toLocaleString() }}</span>
              </div>
              <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-line">
                {{ n.message }}
              </p>
            </div>
            <!-- Right meta panel -->
            <div class="md:w-64 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700 p-5 bg-gray-50 dark:bg-gray-900/40">
              <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                  <span class="text-gray-500">Published</span>
                  <span class="text-gray-800 dark:text-gray-200">{{ new Date(n.created_at).toLocaleString() }}</span>
                </div>
                <div v-if="n.expires_at" class="flex items-center justify-between">
                  <span class="text-gray-500">Expires</span>
                  <span class="text-gray-800 dark:text-gray-200">{{ new Date(n.expires_at).toLocaleString() }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="rounded-xl border border-dashed border-gray-300 p-12 text-center text-gray-500">No notifications yet.</div>
    </div>
  </AppLayout>
</template>