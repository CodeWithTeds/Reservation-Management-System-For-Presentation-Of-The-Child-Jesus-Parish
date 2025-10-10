<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard().url },
  { title: 'User Management', href: route('admin.users.index') },
  { title: 'Create Staff', href: '#' },
];

const form = useForm({
  name: '',
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('admin.users.store'));
};
</script>

<template>
  <Head title="Create Staff" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Create Staff Account</h1>
        <Link :href="route('admin.users.index')" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">Back to Users</Link>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input v-model="form.name" type="text" class="w-full rounded-md border p-2" placeholder="Jane Doe" />
            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email Address</label>
            <input v-model="form.email" type="email" class="w-full rounded-md border p-2" placeholder="jane@example.com" />
            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input v-model="form.password" type="password" class="w-full rounded-md border p-2" placeholder="At least 8 characters" />
            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
          </div>

          <div class="pt-2">
            <button type="submit" class="rounded-md bg-[#0033A0] px-4 py-2 text-white hover:brightness-110 transition" :disabled="form.processing">
              {{ form.processing ? 'Creating...' : 'Create Staff' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
  <slot />
</template>