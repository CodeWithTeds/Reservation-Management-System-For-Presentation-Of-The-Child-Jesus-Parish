<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <header class="bg-[#0033A0] text-white shadow-lg sticky top-0 z-10">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="/images/logo.png" alt="Parish Logo" class="h-12 mr-3">
                    <h1 class="text-xl font-bold">St. John the Baptist Parish</h1>
                </div>
                <nav class="flex items-center space-x-4">
                    <Link :href="route('welcome')" 
                        class="px-4 py-2 rounded-md text-white font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                    Home
                    </Link>
                    <Link :href="route('about')" 
                        class="px-4 py-2 rounded-md text-white font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                    About
                    </Link>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Livestream Section with Text on Left, Video on Right -->
            <div class="max-w-5xl mx-auto">
                <div v-if="livestream && embedUrl" class="flex flex-col lg:flex-row gap-8 mb-8">
                    <!-- Left Column - Text Content -->
                    <div class="lg:w-1/2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ livestream.title }}</h2>
                        
                        <div class="flex items-center mb-4">
                            <span v-if="livestream.is_live" class="bg-red-600 text-white px-3 py-1 rounded-full font-bold flex items-center">
                                <span class="animate-pulse inline-block w-3 h-3 bg-white rounded-full mr-2"></span>
                                LIVE NOW
                            </span>
                            <span v-else class="bg-gray-600 text-white px-3 py-1 rounded-full font-medium">Recent Stream</span>
                            <span class="ml-3 text-gray-600">{{ livestream.platform }}</span>
                        </div>
                        
                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-700 mb-4">
                                Join us for our parish livestream where we broadcast our services to reach our community members who cannot attend in person.
                            </p>
                            <p class="text-gray-700 mb-4">
                                Our livestreams include Sunday Mass, special celebrations, and other parish events. We invite you to participate virtually and be part of our community from wherever you are.
                            </p>
                            <p class="text-gray-700 mb-4">
                                The livestream allows you to experience our services in real-time, connecting with our parish community and participating in prayer and worship together.
                            </p>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-3">Livestream Schedule</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="inline-block w-4 h-4 bg-[#0033A0] rounded-full mt-1.5 mr-3"></span>
                                    <div>
                                        <span class="font-medium">Sunday Mass:</span> 9:00 AM
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="inline-block w-4 h-4 bg-[#0033A0] rounded-full mt-1.5 mr-3"></span>
                                    <div>
                                        <span class="font-medium">Daily Mass:</span> 7:00 AM (Monday-Friday)
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="inline-block w-4 h-4 bg-[#0033A0] rounded-full mt-1.5 mr-3"></span>
                                    <div>
                                        <span class="font-medium">Special Events:</span> As announced
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <button @click="openFullscreen" class="bg-[#0033A0] text-white px-6 py-3 rounded-md font-bold hover:bg-blue-800 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Watch Fullscreen
                        </button>
                    </div>
                    
                    <!-- Right Column - Livestream Video -->
                    <div class="lg:w-1/2">
                        <div class="relative">
                            <div v-if="livestream.is_live" class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full font-bold z-10 flex items-center">
                                <span class="animate-pulse inline-block w-3 h-3 bg-white rounded-full mr-2"></span>
                                LIVE NOW
                            </div>
                            <div class="aspect-video w-full bg-black rounded-lg overflow-hidden shadow-xl">
                                <iframe 
                                    ref="videoIframe"
                                    :src="embedUrl" 
                                    class="w-full h-full" 
                                    allowfullscreen 
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                    referrerpolicy="no-referrer"
                                ></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- No Livestream Available Message -->
                <div v-else class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="text-4xl text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">No Livestream Available</h2>
                    <p class="text-gray-600 max-w-md">There is currently no active or scheduled livestream. Please check back later for upcoming events.</p>
                </div>
            </div>
            
            <!-- Fullscreen Modal -->
            <div v-if="isFullscreen" class="fixed inset-0 bg-black z-50 flex items-center justify-center">
                <button @click="closeFullscreen" class="absolute top-4 right-4 bg-white text-black p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <iframe 
                    v-if="embedUrl"
                    :src="embedUrl" 
                    class="w-full h-full" 
                    allowfullscreen 
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                    referrerpolicy="no-referrer"
                ></iframe>
            </div>

            <!-- Chat Section (Optional) -->
            <div class="max-w-5xl mx-auto mt-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Community Chat</h3>
                    <div class="h-64 overflow-y-auto bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200">
                        <!-- Chat messages would go here -->
                        <p class="text-gray-500 text-center py-8">Chat is currently disabled. Join us during live events to participate!</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Livestreams Section -->
            <div class="max-w-5xl mx-auto mt-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Livestreams</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Example upcoming livestream cards -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800">Sunday Mass</h4>
                            <p class="text-gray-600 mt-1">Scheduled for Sunday, 10:00 AM</p>
                            <div class="mt-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Upcoming
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800">Bible Study Session</h4>
                            <p class="text-gray-600 mt-1">Scheduled for Wednesday, 7:00 PM</p>
                            <div class="mt-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Upcoming
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-[#0033A0] text-white py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <img src="/images/logo.png" alt="Parish Logo" class="h-10 mr-3">
                        <span class="text-lg font-bold">St. John the Baptist Parish</span>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Contact</a>
                        <Link :href="route('about')" class="hover:text-[#FFD633] transition duration-300">About</Link>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Privacy</a>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Terms</a>
                    </div>
                </div>
                <div class="mt-6 text-center text-sm text-gray-300">
                    &copy; {{ new Date().getFullYear() }} St. John the Baptist Parish. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    livestream: Object
});

const isFullscreen = ref(false);
const videoIframe = ref(null);

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

// Function to open fullscreen mode
const openFullscreen = () => {
    isFullscreen.value = true;
    document.body.style.overflow = 'hidden'; // Prevent scrolling when fullscreen
};

// Function to close fullscreen mode
const closeFullscreen = () => {
    isFullscreen.value = false;
    document.body.style.overflow = ''; // Restore scrolling
};

// Function to format date
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>