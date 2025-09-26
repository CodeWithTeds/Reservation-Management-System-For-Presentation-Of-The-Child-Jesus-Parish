<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Modern Header with Glassmorphism -->
        <header class="bg-gradient-to-r from-[#0033A0] to-[#0055cc] text-white sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="/images/logo.png" alt="Parish Logo" class="h-12 mr-4 drop-shadow-md">
                    <h1 class="text-2xl font-bold tracking-tight">St. John the Baptist Parish</h1>
                </div>
                <nav class="flex items-center space-x-6">
                    <Link :href="route('welcome')" 
                        class="px-5 py-2 rounded-full text-white font-medium hover:bg-white/20 transition-all duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-14 0l2 2m0 0l7 7 7-7m-14 0l2-2" />
                        </svg>
                        Home
                    </Link>
                    <Link :href="route('about')" 
                        class="px-5 py-2 rounded-full text-white font-medium hover:bg-white/20 transition-all duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        About
                    </Link>
                </nav>
            </div>
        </header>

        <!-- Main Content with Modern Card Design -->
        <main class="container mx-auto px-6 py-12">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center mb-10">
                    <div class="h-1 w-12 bg-[#FFD633] mr-4 rounded-full"></div>
                    <h2 class="text-4xl font-bold text-[#0033A0] tracking-tight">Parish Livestream</h2>
                </div>
                
                <!-- Livestream Display with Modern UI -->
                <div v-if="livestream && embedUrl" class="mb-12">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gradient-to-br from-gray-900 to-black p-1">
                        <div v-if="livestream.is_live" class="absolute top-4 right-4 bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-1.5 rounded-full font-bold z-10 flex items-center shadow-lg">
                            <span class="animate-pulse inline-block w-3 h-3 bg-white rounded-full mr-2"></span>
                            LIVE NOW
                        </div>
                        <div class="aspect-video w-full bg-black rounded-xl overflow-hidden">
                            <iframe 
                                :src="embedUrl" 
                                class="w-full h-full" 
                                allowfullscreen 
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                referrerpolicy="no-referrer"
                            ></iframe>
                        </div>
                    </div>
                    <div class="mt-6 px-2">
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ livestream.title }}</h3>
                        <div class="flex items-center mt-3">
                            <span v-if="livestream.is_live" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <span class="animate-pulse inline-block w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                Live Now
                            </span>
                            <span v-else class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Recent Stream
                            </span>
                            <span class="mx-3 text-gray-300">|</span>
                            <span class="text-gray-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                {{ livestream.platform }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- No Livestream Available Message with Modern Design -->
                <div v-else class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full opacity-70 blur-3xl"></div>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mt-8 mb-3">No Livestream Available</h3>
                    <p class="text-gray-600 max-w-md mb-8">There is currently no active or scheduled livestream. Please check back later for upcoming events.</p>
                    <button class="px-6 py-3 bg-[#0033A0] text-white rounded-full hover:bg-[#0044cc] transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notify Me About Future Streams
                    </button>
                </div>
                
                <!-- Additional Information with Modern Card Design -->
                <div class="mt-12 bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-[#0033A0] flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">About Our Livestreams</h3>
                    </div>
                    <div class="pl-14">
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            We broadcast our services live to reach our community members who cannot attend in person. 
                            Our livestreams typically include Sunday Mass, special celebrations, and other parish events.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            If you're experiencing any issues with the livestream, please contact our parish office for assistance.
                        </p>
                        <div class="mt-6 flex items-center">
                            <a href="#" class="inline-flex items-center text-[#0033A0] hover:text-[#0055cc] font-medium transition-colors duration-300">
                                Contact Support
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modern Footer with Gradient -->
        <footer class="bg-gradient-to-r from-[#002280] to-[#0033A0] text-white py-12 mt-12">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-6 md:mb-0">
                        <img src="/images/logo.png" alt="Parish Logo" class="h-12 mr-4 drop-shadow-lg">
                        <div>
                            <span class="text-xl font-bold block">St. John the Baptist Parish</span>
                            <span class="text-sm text-gray-300">Serving our community with faith and love</span>
                        </div>
                    </div>
                    <div class="flex space-x-8">
                        <a href="#" class="hover:text-[#FFD633] transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact
                        </a>
                        <Link :href="route('about')" class="hover:text-[#FFD633] transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            About
                        </Link>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Privacy
                        </a>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Terms
                        </a>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-blue-800 text-center text-sm text-gray-300">
                    &copy; {{ new Date().getFullYear() }} St. John the Baptist Parish. All rights reserved.
                </div>
            </div>
        </footer>
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
</script>