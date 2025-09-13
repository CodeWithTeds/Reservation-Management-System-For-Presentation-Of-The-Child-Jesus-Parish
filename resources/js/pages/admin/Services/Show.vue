<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
    title: 'View',
    href: '#',
  },
];
</script>

<template>
  <Head title="View Service" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Service Details</h1>
        <div class="flex space-x-2">
          <Link 
            :href="route('admin.services.edit', service.service_id)" 
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
          >
            Edit
          </Link>
          <Link 
            href="route('admin.services.destroy', service.service_id)" 
            method="delete"
            as="button" 
            type="button"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
        
          >
            Delete
          </Link>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Service Information</h2>
            
            <div class="mb-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</p>
              <p class="text-base text-gray-900 dark:text-white">{{ service.service_id }}</p>
            </div>
            
            <div class="mb-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Service Type</p>
              <p class="text-base text-gray-900 dark:text-white">{{ service.service_type }}</p>
            </div>
            
            <div class="mb-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacity</p>
              <p class="text-base text-gray-900 dark:text-white">{{ service.capacity || 'Not specified' }}</p>
            </div>
          </div>
          
          <div>
            <div class="mb-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</p>
              <p class="text-base text-gray-900 dark:text-white whitespace-pre-line">{{ service.description || 'No description provided' }}</p>
            </div>
            
            <div class="mb-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Requirements</p>
              <p class="text-base text-gray-900 dark:text-white whitespace-pre-line">{{ service.requirements || 'No requirements specified' }}</p>
            </div>
          </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</p>
              <p class="text-base text-gray-900 dark:text-white">{{ new Date(service.created_at).toLocaleString() }}</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</p>
              <p class="text-base text-gray-900 dark:text-white">{{ new Date(service.updated_at).toLocaleString() }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="flex justify-start mt-4">
        <Link 
          :href="route('admin.services.index')" 
          class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
        >
          Back to Services
        </Link>
      </div>
    </div>
  </AppLayout>
</template>