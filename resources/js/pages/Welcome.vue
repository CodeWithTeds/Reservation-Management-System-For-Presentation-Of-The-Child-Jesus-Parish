<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
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
                    <div class="text-[#FFD633] text-2xl font-bold">PCJP</div>
                    <h1 class="text-xl font-semibold hidden sm:block">Reservation Management System</h1>
                </div>
                <nav class="flex items-center space-x-4">
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
                        <div class="p-1 bg-[#FFD633]"></div>
                        <div class="p-8">
                            <div class="flex justify-center mb-6">
                                <div class="h-24 w-24 rounded-full bg-[#0033A0] flex items-center justify-center">
                                    <span class="text-[#FFD633] text-4xl font-bold">PCJP</span>
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
                            <span class="text-[#FFD633] mr-2">PCJP</span> Reservation System
                        </h3>
                        <p class="text-sm text-gray-400">Presentation Of The Child Jesus Parish</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Contact</a>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">About</a>
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
