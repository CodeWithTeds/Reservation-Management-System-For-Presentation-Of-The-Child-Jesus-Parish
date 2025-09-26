<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard().url },
  { title: 'Notifications', href: '#' },
  { title: 'Create', href: '#' },
];

const form = useForm({
  title: '',
  message: '',
  expires_at: '',
  is_active: true,
});

const submit = () => {
  form.post(route('admin.notifications.store'));
};
</script>

<template>
  <Head title="Create Notification" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <h1 class="text-2xl font-bold mb-4">Create Notification</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
          <input v-model="form.title" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter notification title" />
          <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
          <textarea v-model="form.message" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="5" placeholder="Enter the notification message"></textarea>
          <div v-if="form.errors.message" class="text-red-500 text-sm mt-1">{{ form.errors.message }}</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expires At (optional)</label>
            <input v-model="form.expires_at" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            <div v-if="form.errors.expires_at" class="text-red-500 text-sm mt-1">{{ form.errors.expires_at }}</div>
          </div>
          <div class="flex items-center">
            <input id="is_active" v-model="form.is_active" type="checkbox" class="mr-2" />
            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
          </div>
        </div>
        <div class="flex gap-2">
          <Button type="submit" :disabled="form.processing" class="bg-indigo-600 hover:bg-indigo-700 text-white">Save</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>