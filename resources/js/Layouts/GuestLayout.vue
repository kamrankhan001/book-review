<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Navigation -->
        <Navbar />

        <!-- Page Heading -->
        <header v-if="$slots.header">
            <div class="max-w-screen-xl mx-auto p-4 my-4">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main class="transition-colors duration-300">
            <slot />
        </main>
    </div>
</template>