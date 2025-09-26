<template>
    <div class="min-h-screen flex flex-col bg-black">
        <!-- Minimal Header -->
        <header class="bg-[#0033A0] text-white py-2 px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="/images/logo.png" alt="Parish Logo" class="h-8 mr-2">
                <h1 class="text-lg font-bold">St. John the Baptist Parish Livestream</h1>
            </div>
            <Link :href="route('welcome')" class="text-white hover:text-[#FFD633]">
                Back to Home
            </Link>
        </header>

        <!-- Main Content - Fullscreen Livestream -->
        <main class="flex-grow flex flex-col">
            <div v-if="livestream && embedUrl" class="flex-grow flex flex-col">
                <!-- Livestream Video (takes most of the screen) -->
                <div class="flex-grow relative">
                    <div v-if="livestream.is_live" class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full font-bold z-10 flex items-center">
                        <span class="animate-pulse inline-block w-3 h-3 bg-white rounded-full mr-2"></span>
                        LIVE NOW
                    </div>
                    <iframe 
                        :src="embedUrl" 
                        class="w-full h-full" 
                        allowfullscreen 
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                        referrerpolicy="no-referrer"
                    ></iframe>
                </div>
                
                <!-- Livestream Info (minimal) -->
                <div class="bg-[#0033A0] text-white p-4">
                    <h2 class="text-xl font-bold">{{ livestream.title }}</h2>
                    <div class="flex items-center mt-1">
                        <span v-if="livestream.is_live" class="text-red-400 font-medium">Live Now</span>
                        <span v-else class="text-gray-300 font-medium">Recent Stream</span>
                    </div>
                </div>
            </div>
            
            <!-- No Livestream Available Message -->
            <div v-else class="flex-grow flex flex-col items-center justify-center text-white text-center p-4">
                <div class="text-4xl text-gray-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-200 mb-2">No Livestream Available</h2>
                <p class="text-gray-400 max-w-md">There is currently no active or scheduled livestream. Please check back later for upcoming events.</p>
                <Link :href="route('welcome')" class="mt-8 px-6 py-2 bg-[#0033A0] text-white rounded-md hover:bg-[#002280] transition duration-300">
                    Return to Homepage
                </Link>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    livestream: Object
});

// Compute the embed URL for Facebook videos
const embedUrl = computed(() => {
    if (!props.livestream || !props.livestream.url) return null;
    
    // Handle Facebook URLs
    if (props.livestream.platform === 'Facebook') {
        // Extract video ID from Facebook URL
        const url = props.livestream.url;
        
        // Handle different Facebook URL formats
        if (url.includes('facebook.com/watch')) {
            // Format: https://www.facebook.com/watch?v=1234567890
            const videoId = new URL(url).searchParams.get('v');
            if (videoId) {
                return `https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/watch?v=${videoId}&show_text=false&t=0`;
            }
        } else if (url.includes('facebook.com/') && url.includes('/videos/')) {
            // Format: https://www.facebook.com/username/videos/1234567890
            const regex = /facebook\.com\/(?:[^\/]+)\/videos\/(\d+)/;
            const match = url.match(regex);
            if (match && match[1]) {
                return `https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/watch?v=${match[1]}&show_text=false&t=0`;
            }
        } else if (url.includes('fb.watch/')) {
            // Format: https://fb.watch/abcd1234/
            // This requires additional handling as fb.watch URLs are shortened
            // For now, we'll return the original URL wrapped in the embed format
            return `https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(url)}&show_text=false&t=0`;
        }
    }
    
    // Return null if no valid embed URL could be generated
    return null;
});

// Format date for display
const formatDate = (dateString) => {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    }).format(date);
};
</script>

<style scoped>
/* Make sure the iframe takes up the full available space */
iframe {
    aspect-ratio: 16/9;
    height: calc(100vh - 120px); /* Adjust based on header/footer height */
    max-height: calc(100vh - 120px);
}

@media (max-width: 768px) {
    iframe {
        height: calc(100vh - 150px);
    }
}
</style>