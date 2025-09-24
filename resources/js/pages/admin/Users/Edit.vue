<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Form } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';

interface UserItem {
  id: number;
  name: string;
  email: string;
  role: string;
}

const props = defineProps<{ user: UserItem }>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard().url },
  { title: 'User Management', href: route('admin.users.index') },
  { title: `Edit #${props.user.id}`, href: '#' },
];
</script>

<template>
  <Head title="Edit User" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <h1 class="text-2xl font-bold mb-4">Edit User</h1>
      <Form :data="{ name: props.user.name, email: props.user.email, role: props.user.role }"
            :method="'put'" :action="route('admin.users.update', props.user.id)" v-slot="{ processing }" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
          <input v-model="props.user.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input v-model="props.user.email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
          <select v-model="props.user.role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="admin">Admin</option>
            <option value="client">Client</option>
          </select>
        </div>
        <button type="submit" :disabled="processing" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
      </Form>
    </div>
  </AppLayout>
</template>