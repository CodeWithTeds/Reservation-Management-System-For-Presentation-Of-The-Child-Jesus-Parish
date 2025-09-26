<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{ livestream: null | { id: number; title: string | null; platform: string; url: string; is_live: boolean; scheduled_at: string | null } }>();

const embedUrl = computed(() => {
  if (!props.livestream?.url) return null;
  try {
    const url = new URL(props.livestream.url);
    // If it's a Facebook watch/livestream URL, convert to plugins/video.php embed
    // Accept typical forms like https://www.facebook.com/{page}/live/ or watch/?v=VIDEO_ID
    const href = props.livestream.url;
    if (href.includes('facebook.com')) {
      // Encode original URL for fb embed plugin
      const encoded = encodeURIComponent(href);
      return `https://www.facebook.com/plugins/video.php?href=${encoded}&show_text=false&height=450&width=800&autoplay=true`;
    }
    // Fallback to the given URL (could be an iframe-friendly URL)
    return url.toString();
  } catch (e) {
    return null;
  }
});
</script>

<template>
  <AppLayout>
    <Head title="Livestream" />
    <div class="py-8">
      <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Livestream</h1>
        <p v-if="!livestream" class="text-gray-600">No livestream is available right now.</p>
        <div v-else>
          <h2 v-if="livestream.title" class="text-xl font-semibold mb-4">{{ livestream.title }}</h2>
          <div class="aspect-video w-full bg-black rounded-lg overflow-hidden shadow">
            <iframe
              v-if="embedUrl"
              :src="embedUrl"
              width="100%"
              height="450"
              style="border:none;overflow:hidden"
              scrolling="no"
              frameborder="0"
              allowfullscreen="true"
              allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
            ></iframe>
            <div v-else class="text-white flex items-center justify-center h-[450px]">
              Unable to load stream. Please try opening directly:
              <a :href="livestream.url" target="_blank" rel="noopener" class="ml-2 underline text-blue-300">Open</a>
            </div>
          </div>
          <p class="mt-3 text-sm text-gray-500">
            Platform: {{ livestream.platform }}
            <span v-if="livestream.is_live" class="ml-2 inline-flex items-center px-2 py-0.5 rounded bg-red-600 text-white text-xs">LIVE</span>
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>