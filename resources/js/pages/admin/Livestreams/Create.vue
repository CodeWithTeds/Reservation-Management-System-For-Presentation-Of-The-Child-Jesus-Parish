<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';
import { PropType, computed } from 'vue';

interface Livestream {
  id?: number;
  platform: string;
  title: string;
  url: string;
  is_live: boolean;
  scheduled_at?: string | null;
}

const props = defineProps({
  livestream: {
    type: Object as PropType<Livestream | null>,
    required: false,
    default: null,
  }
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: dashboard().url },
  { title: 'Livestream', href: route('admin.livestreams.create') },
  { title: props.livestream ? 'Manage' : 'Create', href: '#' },
];

const form = useForm<Livestream>({
  platform: props.livestream?.platform ?? 'facebook',
  title: props.livestream?.title ?? '',
  url: props.livestream?.url ?? '',
  is_live: props.livestream?.is_live ?? false,
  scheduled_at: props.livestream?.scheduled_at ?? null,
});

const embedUrl = computed(() => {
  const url = form.url;
  if (!url) return '';
  try {
    const u = new URL(url);
    // If it's a Facebook video/live URL, convert to embed format
    // Supports fb.watch short links and facebook.com URLs
    if (u.host.includes('facebook')) {
      const encoded = encodeURIComponent(url);
      return `https://www.facebook.com/plugins/video.php?href=${encoded}&show_text=false&autoplay=true`;
    }
    if (u.host.includes('fb.watch')) {
      return `https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(url)}&show_text=false&autoplay=true`;
    }
  } catch (e) {
    return '';
  }
  return '';
});

const submit = () => {
  form.post(route('admin.livestreams.store'));
};
</script>

<template>
  <Head title="Admin Livestream" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ props.livestream ? 'Manage Livestream' : 'Create Livestream' }}</h1>
        <Link :href="route('livestream')" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700 transition">View Public Page</Link>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
        <form @submit.prevent="submit" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Title</label>
              <input v-model="form.title" type="text" class="w-full rounded-md border p-2" placeholder="Sunday Mass Livestream" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Platform</label>
              <select v-model="form.platform" class="w-full rounded-md border p-2">
                <option value="facebook">Facebook</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Facebook Live/Video URL</label>
              <input v-model="form.url" type="url" class="w-full rounded-md border p-2" placeholder="https://www.facebook.com/yourpage/videos/123456789" />
            </div>
            <div>
              <label class="inline-flex items-center space-x-2">
                <input v-model="form.is_live" type="checkbox" />
                <span>Currently Live</span>
              </label>
            </div>
            <div>
             
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition" :disabled="form.processing">Save</button>
            <span v-if="form.recentlySuccessful" class="text-green-600">Saved!</span>
          </div>
        </form>
      </div>

      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
        <h2 class="text-lg font-semibold mb-2">Preview</h2>
        <div v-if="embedUrl" class="aspect-video w-full">
          <iframe :src="embedUrl" width="100%" height="100%" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        </div>
        <p v-else class="text-gray-500">Enter a valid Facebook video/live URL to preview.</p>
      </div>
    </div>
  </AppLayout>
</template>