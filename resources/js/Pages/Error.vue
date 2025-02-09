<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <Head title="Error" />

    <Navbar />

    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-gray-900">
        <h1 class="text-6xl font-bold text-red-600 mb-4">Oops!</h1>
        <p class="text-2xl mb-2">Something went wrong.</p>
        <p class="text-gray-600 mb-6">We’re working to fix the issue. Please try again later.</p>

        <button
            @click="() => window.location.reload()"
            class="px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
            Try Again
        </button>

        <Link href="/" class="mt-4 text-blue-500 hover:underline">
            Go back to Home
        </Link>
    </div>
</template>
