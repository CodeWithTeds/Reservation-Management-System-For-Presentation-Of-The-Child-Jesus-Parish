<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="About Us - Presentation Of The Child Jesus Parish">
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
                    <Link :href="'/'" class="px-4 py-2 rounded-md text-white font-medium hover:bg-white hover:text-[#0033A0] transition duration-300">
                        Home
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

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Hero Section -->
            <section class="bg-gradient-to-b from-[#0033A0] to-blue-700 text-white py-16">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">About Our Parish</h1>
                    <p class="text-xl max-w-3xl mx-auto">Learn more about the Presentation Of The Child Jesus Parish and our mission to serve the community.</p>
                </div>
            </section>

            <!-- About Content -->
            <section class="py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <div class="mb-12 flex justify-center">
                            <img src="images/logo.png" alt="Parish Logo" class="w-32 h-32">
                        </div>
                        
                        <h2 class="text-3xl font-bold text-center text-[#333333] mb-8">Our History</h2>
                        <p class="text-lg text-gray-700 mb-6">
                            The Presentation Of The Child Jesus Parish was established in [year] to serve the growing Catholic community in our area. 
                            What began as a small gathering of faithful has grown into a vibrant parish community dedicated to spreading the Gospel 
                            and serving those in need.
                        </p>
                        <p class="text-lg text-gray-700 mb-12">
                            Over the years, our parish has expanded its facilities and services to better meet the spiritual and community needs 
                            of our parishioners. Today, we continue to grow and adapt while remaining true to our core mission of faith, service, and community.
                        </p>

                        <h2 class="text-3xl font-bold text-center text-[#333333] mb-8">Our Mission</h2>
                        <p class="text-lg text-gray-700 mb-6">
                            At the Presentation Of The Child Jesus Parish, our mission is to create a welcoming community where all can encounter Christ, 
                            grow in faith, and be inspired to share God's love with others. We strive to:
                        </p>
                        <ul class="list-disc pl-8 text-lg text-gray-700 mb-12">
                            <li class="mb-2">Celebrate the Eucharist with reverence and joy</li>
                            <li class="mb-2">Provide spiritual formation for all ages</li>
                            <li class="mb-2">Reach out to those in need within our community</li>
                            <li class="mb-2">Foster a sense of belonging and mutual support</li>
                            <li>Promote social justice and peace</li>
                        </ul>

                        <h2 class="text-3xl font-bold text-center text-[#333333] mb-8">Our Team</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                <div class="h-24 w-24 rounded-full bg-gray-200 mx-auto mb-4"></div>
                                <h3 class="text-xl font-bold text-center text-[#333333] mb-2">Fr. John Doe</h3>
                                <p class="text-center text-gray-600">Parish Priest</p>
                                <p class="text-center text-gray-600 mt-4">Leading our parish since 2015 with dedication and compassion.</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                <div class="h-24 w-24 rounded-full bg-gray-200 mx-auto mb-4"></div>
                                <h3 class="text-xl font-bold text-center text-[#333333] mb-2">Sr. Mary Smith</h3>
                                <p class="text-center text-gray-600">Parish Administrator</p>
                                <p class="text-center text-gray-600 mt-4">Coordinating parish activities and ensuring smooth operations.</p>
                            </div>
                        </div>

                        <h2 class="text-3xl font-bold text-center text-[#333333] mb-8">Visit Us</h2>
                        <div class="bg-gray-100 p-8 rounded-lg mb-12">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <h3 class="text-xl font-bold text-[#333333] mb-4">Mass Schedule</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li><span class="font-semibold">Sunday:</span> 8:00 AM, 10:30 AM, 5:00 PM</li>
                                        <li><span class="font-semibold">Weekdays:</span> 7:30 AM</li>
                                        <li><span class="font-semibold">Saturday:</span> 9:00 AM, 5:00 PM (Vigil)</li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-[#333333] mb-4">Contact Information</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li><span class="font-semibold">Address:</span> 123 Church Street, City, State ZIP</li>
                                        <li><span class="font-semibold">Phone:</span> (123) 456-7890</li>
                                        <li><span class="font-semibold">Email:</span> info@parishname.org</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

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
                        <Link :href="'/about'" class="hover:text-[#FFD633] transition duration-300">About</Link>
                        <a href="#" class="hover:text-[#FFD633] transition duration-300">Contact</a>
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