<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div>

        <!-- Navigation -->
        <Navbar />

        <!-- Page Heading -->
        <header  v-if="$slots.header">
            <div class="max-w-screen-xl mx-auto p-4 my-4">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <slot />

    </div>
</template>
