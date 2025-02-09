<script setup>
import AddBook from './AddBook.vue';
import EditBook from './EditBook.vue';
import DeleteBook from './DeleteBook.vue';

import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


// Define props to accept the books data
const props = defineProps({
    books: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

const form = useForm({
    search: props.filters.search || '',
});

// Change page function
const goToPage = (url) => {
    if (url) {
        router.visit(url, { preserveState: true });
    }
};

const searchBook = () => {
    form.get(route('dashboard'), {
        preserveState: true,
        replace: true, // Keeps URL clean
    });
};
</script>

<template>
    <div class="grid grid-cols-2 items-center justify-between py-2 mb-2">

        <form class="flex-1" @submit.prevent="searchBook">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search" v-model="form.search" @input="searchBook"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Book, Author..." required />
            </div>
        </form>

        <!-- AddBook component with a listener for adding a new book -->
        <div>
            <AddBook />

        </div>
    </div>

    <!-- Loop through the books and render each one -->
    <div v-if="books.data.length === 0" class="text-center text-gray-500 dark:text-gray-400 py-5 border mb-2">
        No books found.
    </div>
    
    <div v-for="book in books.data" :key="book.id" class="space-y-4 border mb-2">
        <div class="flex px-4 bg-white dark:bg-gray-900">
            <img :src="'/storage/' + book.cover_image" alt="Book Cover" class="w-24 h-32 object-cover rounded-lg">
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ book.title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Author: {{ book.author }}</p>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ book.description }}</p>
                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">Created on: {{ book.created_at }}</p>
            </div>
        </div>

        <div class="me-2 flex space-x-2 justify-end">
            <!-- EditBook component with a listener for updating a book -->
            <EditBook :book="book" />
            <!-- DeleteBook component with a listener for deleting a book -->
            <DeleteBook :book="book" />
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-end mb-3">
        <nav v-if="books.links.length > 3" aria-label="Pagination" class="mt-4">
            <ul class="inline-flex -space-x-px text-sm">
                <li v-for="(link, index) in books.links" :key="index">
                    <button @click="goToPage(link.url)" v-html="link.label" :class="[
                        'flex items-center justify-center px-3 h-8 leading-tight border',
                        link.active
                            ? 'bg-blue-600 text-white border-gray-300'
                            : 'bg-white text-gray-500 border-gray-300 hover:bg-gray-100 hover:text-gray-700',
                        index === 0 ? 'rounded-s-lg' : '',
                        index === books.links.length - 1 ? 'rounded-e-lg' : '',
                        !link.url ? 'cursor-not-allowed opacity-50' : '',
                    ]" :disabled="!link.url"></button>
                </li>
            </ul>
        </nav>
    </div>



</template>
