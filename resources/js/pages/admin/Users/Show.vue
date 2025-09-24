<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { PropType } from 'vue';

interface UserItem {
  id: number;
  name: string;
  email: string;
  role: string;
  created_at: string;
}

defineProps({
  user: {
    type: Object as PropType<UserItem>,
    required: true,
  },
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard().url },
  { title: 'User Management', href: '#' },
  { title: 'View User', href: '#' },
];
</script>

<template>
  <Head title="View User" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">User Details</h2>
        <div class="space-y-3">
          <div>
            <span class="text-gray-500 dark:text-gray-400">ID:</span>
            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ user.id }}</span>
          </div>
          <div>
            <span class="text-gray-500 dark:text-gray-400">Name:</span>
            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ user.name }}</span>
          </div>
          <div>
            <span class="text-gray-500 dark:text-gray-400">Email:</span>
            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ user.email }}</span>
          </div>
          <div>
            <span class="text-gray-500 dark:text-gray-400">Role:</span>
            <span class="ml-2">
              <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                {{ user.role || 'client' }}
              </span>
            </span>
          </div>
          <div>
            <span class="text-gray-500 dark:text-gray-400">Joined:</span>
            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ new Date(user.created_at).toLocaleDateString() }}</span>
          </div>
        </div>
        <div class="mt-6">
          <Link :href="route('admin.users.index')" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">Back to Users</Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>