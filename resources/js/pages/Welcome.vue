<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { computed } from 'vue';

const props = defineProps<{ livestream: null | { id: number; title: string | null; platform: string; url: string; is_live: boolean; scheduled_at: string | null } }>();

// Check if livestream should be displayed based on schedule
const isLivestreamAvailable = computed(() => {
    if (!props.livestream) return false;

    // If livestream is marked as live, always show it
    if (props.livestream.is_live) return true;

    // If there's a scheduled time, check if current time meets the schedule
    if (props.livestream.scheduled_at) {
        const now = new Date();
        const scheduledTime = new Date(props.livestream.scheduled_at);

        // Only show if current time is at or after the scheduled time
        return now >= scheduledTime;
    }

    // If no schedule and not live, don't show
    return false;
});

// Format scheduled date for display
const formattedSchedule = computed(() => {
    if (!props.livestream || !props.livestream.scheduled_at) return '';

    const date = new Date(props.livestream.scheduled_at);
    return date.toLocaleString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
});

const embedUrl = computed(() => {
    if (!props.livestream?.url || !isLivestreamAvailable.value) return null;
    try {
        const url = new URL(props.livestream.url);
        // If it's a Facebook watch/livestream URL, convert to plugins/video.php embed
        if (props.livestream.url.includes('facebook.com')) {
            // Encode original URL for fb embed plugin
            const encoded = encodeURIComponent(props.livestream.url);
            return `https://www.facebook.com/plugins/video.php?href=${encoded}&show_text=false&height=450&width=800&autoplay=true`;
        }
        // Fallback to the given URL
        return url.toString();
    } catch (e) {
        return null;
    }
});
</script>

<template>

    <Head title="Presentation Of The Child Jesus Parish">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="true">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>
    <div class="min-h-screen flex flex-col bg-white">
        <!-- Header/Navigation -->
        <header class="bg-[#0033A0] text-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img src="images/logo.png" alt="logo" class="w-12 h-12">

                    <h1 class="text-xl font-semibold hidden sm:block">Reservation Management System</h1>
                </div>
                <nav class="flex items-center space-x-4">
                    <Link :href="route('about')"
                        class="px-4 py-2 rounded-md text-white font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                    About
                    </Link>
                    <Link v-if="$page.props.auth.user" :href="dashboard()"
                        class="px-4 py-2 rounded-md bg-white text-[#0033A0] font-medium hover:bg-[#FFD633] hover:text-[#333333] transition duration-300">
                    Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="login()"
                            class="px-4 py-2 rounded-md border border-white text-white font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                        Log in
                        </Link>
                        <Link :href="register()"
                            class="px-4 py-2 rounded-md bg-[#FFD633] text-[#333333] font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                        Register
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-[#0033A0] to-blue-700 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Our Parish Reservation System</h1>
                    <p class="text-xl mb-8">Streamline your bookings for masses, events, and sacraments with our
                        easy-to-use
                        platform.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <Link :href="login()"
                            class="px-6 py-3 rounded-md bg-[#FFD633] text-[#333333] font-bold text-center hover:bg-yellow-400 transition duration-300">
                        Get Started
                        </Link>

                        <a href="#features"
                            class="px-6 py-3 rounded-md border-2 border-white text-white font-bold text-center hover:bg-white hover:text-[#0033A0] transition duration-300">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">

                        <div class="p-8">
                            <div class="flex justify-center mb-6">
                                <div class="h-24 w-24 rounded-full bg-[#0033A0] flex items-center justify-center">
                                    <img src="images/logo.png" alt="logo" class="w-20 h-20">
                                </div>
                            </div>
                            <h3 class="text-[#333333] text-xl font-bold text-center mb-4">Presentation Of The Child
                                Jesus Parish
                            </h3>
                            <p class="text-[#333333] text-center">Serving our community with faith and dedication</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-[#333333] mb-12">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="h-16 w-16 rounded-full bg-[#0033A0] flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FFD633]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-center text-[#333333] mb-2">Event Scheduling</h3>
                        <p class="text-center text-gray-600">Book masses, baptisms, weddings, and other sacraments with
                            our
                            easy-to-use calendar system.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="h-16 w-16 rounded-full bg-[#0033A0] flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FFD633]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-center text-[#333333] mb-2">Room Management</h3>
                        <p class="text-center text-gray-600">Reserve parish facilities for meetings, retreats, and
                            community
                            gatherings.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="h-16 w-16 rounded-full bg-[#0033A0] flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FFD633]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-center text-[#333333] mb-2">Confirmation System</h3>
                        <p class="text-center text-gray-600">Receive automatic confirmations and reminders for your
                            scheduled
                            events.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Livestream Section - Standalone -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-[#333333] mb-8">Parish Livestream</h2>
                <div v-if="livestream && embedUrl" class="flex flex-col md:flex-row gap-8">
                    <!-- Left Column - Text Content -->
                    <div class="md:w-1/2">
                        <h3 class="text-2xl font-bold text-[#0033A0] mb-4">{{ livestream.title || 'Parish Livestream' }}
                        </h3>
                        <div class="mb-4">
                            <span v-if="livestream.is_live"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-600 text-white">
                                <span class="animate-pulse inline-block w-2 h-2 bg-white rounded-full mr-2"></span>
                                LIVE NOW
                            </span>
                            <span v-else
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-800">
                                Recent Stream
                            </span>
                        </div>
                        <p class="text-gray-700 mb-4">
                            Join us for our regular livestreamed masses and special events. Stay connected with our
                            parish
                            community from anywhere in the world.
                        </p>
                        <p class="text-gray-700 mb-6">
                            We broadcast all major celebrations, including Sunday masses, special feast days, and parish
                            events.
                        </p>

                    </div>

                    <!-- Right Column - Livestream Video -->
                    <div class="md:w-1/2">
                        <div class="relative aspect-video bg-black rounded-lg overflow-hidden shadow-xl">
                            <div v-if="livestream.is_live"
                                class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full font-bold z-10 flex items-center">
                                <span class="animate-pulse inline-block w-3 h-3 bg-white rounded-full mr-2"></span>
                                LIVE
                            </div>
                            <iframe v-if="embedUrl" :src="embedUrl" class="w-full h-full" allowfullscreen
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                referrerpolicy="no-referrer"></iframe>
                            <div v-else class="flex items-center justify-center h-full text-white">
                                <p>Unable to load stream</p>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500 flex items-center justify-between">
                            <div>Platform: {{ livestream?.platform || 'Facebook' }}</div>

                        </div>
                    </div>
                </div>

                <!-- No Livestream Available Message -->
                <div v-else class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="text-4xl text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No Livestream Available</h3>
                    <p class="text-gray-600 max-w-md mb-6">There is currently no active or scheduled livestream. Please
                        check
                        back later for upcoming events.</p>
                    <Link :href="route('livestream.display')"
                        class="inline-flex items-center px-4 py-2 bg-[#0033A0] text-white rounded-md hover:bg-blue-700 transition duration-300">
                    View All Streams
                    </Link>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-[#0033A0]">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-6">Ready to Get Started?</h2>
                <p class="text-xl text-white mb-8 max-w-2xl mx-auto">Join our parish community and start managing your
                    reservations today.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <Link :href="register()"
                        class="px-8 py-3 rounded-md bg-[#FFD633] text-[#333333] font-bold hover:bg-yellow-400 transition duration-300">
                    Create an Account
                    </Link>
                    <Link :href="login()"
                        class="px-8 py-3 rounded-md border-2 border-white text-white font-bold hover:bg-white hover:text-[#0033A0] transition duration-300">
                    Sign In
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#333333] text-white py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold flex items-center">
                            <span class="text-[#FFD633] mr-2">add logo here</span> Reservation System
                        </h3>
                        <p class="text-sm text-gray-400">Presentation Of The Child Jesus Parish</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Contact</a>
                        <Link :href="route('about')" class="hover:text-[#FFD633] transition duration-300">About</Link>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Privacy</a>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Terms</a>
                    </div>
                </div>
                <div class="mt-8 pt-4 border-t border-gray-700 text-center text-sm text-gray-400">
                    &copy; {{ new Date().getFullYear() }} Presentation Of The Child Jesus Parish. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
body {
    font-family: 'Montserrat', sans-serif;
}
</style>
