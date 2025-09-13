<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { PropType } from 'vue';
import { route } from 'ziggy-js';

interface Service {
  service_id: number;
  service_type: string;
  description: string;
  capacity: number;
  requirements: string;
  created_at: string;
  updated_at: string;
}

const props = defineProps({
  service: {
    type: Object as PropType<Service>,
    required: true
  }
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Services',
    href: route('admin.services.index'),
  },
  {
    title: 'Edit',
    href: '#',
  },
];

const form = useForm({
  service_type: props.service.service_type,
  description: props.service.description,
  capacity: props.service.capacity,
  requirements: props.service.requirements,
});

const submit = () => {
  form.put(route('admin.services.update', props.service.service_id));
};
</script>

<template>
  <Head title="Edit Service" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Edit Service</h1>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label for="service_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service Type</label>
            <select 
              id="service_type" 
              v-model="form.service_type" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              required
            >
              <option value="">Select a service type</option>
              <option value="Hall">Hall</option>
              <option value="Meeting Room">Meeting Room</option>
              <option value="Baptism">Baptism</option>
              <option value="Wedding">Wedding</option>
              <option value="Confession">Confession</option>
              <option value="Other">Other</option>
            </select>
            <div v-if="form.errors.service_type" class="text-red-500 mt-1 text-sm">{{ form.errors.service_type }}</div>
          </div>

          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea 
              id="description" 
              v-model="form.description" 
              rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            ></textarea>
            <div v-if="form.errors.description" class="text-red-500 mt-1 text-sm">{{ form.errors.description }}</div>
          </div>

          <div class="mb-4">
            <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity (PAX)</label>
            <input 
              id="capacity" 
              type="number" 
              v-model="form.capacity" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              min="0"
            />
            <div v-if="form.errors.capacity" class="text-red-500 mt-1 text-sm">{{ form.errors.capacity }}</div>
          </div>

          <div class="mb-4">
            <label for="requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requirements</label>
            <textarea 
              id="requirements" 
              v-model="form.requirements" 
              rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              placeholder="e.g. baptismal certificate, marriage license, etc."
            ></textarea>
            <div v-if="form.errors.requirements" class="text-red-500 mt-1 text-sm">{{ form.errors.requirements }}</div>
          </div>

          <div class="flex justify-end space-x-3">
            <Link 
              :href="route('admin.services.index')" 
              class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
            >
              Cancel
            </Link>
            <button 
              type="submit" 
              class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              :disabled="form.processing"
            >
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>