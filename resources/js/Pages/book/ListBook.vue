<script setup>
import AddBook from './AddBook.vue';
import EditBook from './EditBook.vue';
import DeleteBook from './DeleteBook.vue';
import { router, useForm } from '@inertiajs/vue3';

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

const goToPage = (url) => {
    if (url) {
        router.visit(url, { preserveState: true });
    }
};

const searchBook = () => {
    form.get(route('dashboard'), {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <main class="dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-4 mb-6">
            <form @submit.prevent="searchBook" class="w-full">
                <label for="book-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-5.2-5.2M16.8 10.4a6.4 6.4 0 1 1-12.8 0 6.4 6.4 0 0 1 12.8 0Z" />
                        </svg>
                    </div>
                    <input
                        id="book-search"
                        type="search"
                        v-model="form.search"
                        @input="searchBook"
                        class="block w-full p-3 ps-10 text-sm rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search Book, Author..."
                    />
                </div>
            </form>
    
            <div class="text-end">
                <AddBook />
            </div>
        </div>
    
        <div v-if="books.data.length === 0" class="text-center text-gray-500 dark:text-gray-400 py-10 border rounded-lg">
            No books found.
        </div>
    
        <div v-for="book in books.data" :key="book.id" class="border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 shadow-sm overflow-hidden mb-4">
            <div class="flex p-4">
                <img :src="'/storage/' + book.cover_image" alt="Book Cover" class="w-24 h-32 object-cover rounded-lg shadow-md" />
                <div class="ml-4 flex-1">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ book.title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Author: {{ book.author }}</p>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">{{ book.description }}</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">Created on: {{ book.created_at }}</p>
                </div>
            </div>
    
            <div class="flex justify-end gap-2 px-4 pb-4">
                <EditBook :book="book" />
                <DeleteBook :book="book" />
            </div>
        </div>
    
        <div class="flex justify-center mt-6">
            <nav v-if="books.links.length > 3" aria-label="Pagination">
                <ul class="inline-flex items-center space-x-1 text-sm">
                    <li v-for="(link, index) in books.links" :key="index">
                        <button
                            @click="goToPage(link.url)"
                            v-html="link.label"
                            :class="[
                                'px-4 py-2 rounded-md border',
                                link.active
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700',
                                !link.url ? 'cursor-not-allowed opacity-50' : '',
                            ]"
                            :disabled="!link.url"
                        />
                    </li>
                </ul>
            </nav>
        </div>
    </main>
</template>
