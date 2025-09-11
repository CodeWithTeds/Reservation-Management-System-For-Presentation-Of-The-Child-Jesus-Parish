<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { route } from 'ziggy-js';

const form = useForm({
  name: '',
  description: '',
  capacity: null,
  status: 'available',
});

const submit = () => {
  form.post(route('rooms.store'));
};
</script>

<template>
  <AppLayout>

    <Head title="Create Room" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">Create New Room</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <Label for="name">Room Name</Label>
                <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus />
                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
              </div>

              <div>
                <Label for="description">Description</Label>
                <Textarea id="description" v-model="form.description" class="mt-1 block w-full" :rows="3" />
                <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}
                </div>
              </div>

              <div>
                <Label for="capacity">Capacity</Label>
                <Input id="capacity" v-model="form.capacity" type="number" min="1" class="mt-1 block w-full" />
                <div v-if="form.errors.capacity" class="text-red-500 text-sm mt-1">{{ form.errors.capacity }}</div>
              </div>

              <div class="flex items-center justify-end mt-4">
                <Button type="submit" class="ml-4" :disabled="form.processing">
                  Create Room
                </Button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>