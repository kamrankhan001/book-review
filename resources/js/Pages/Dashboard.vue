<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ListBook from './book/ListBook.vue';
import ListReview from './review/ListReview.vue';

import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import { initTabs } from 'flowbite'

// Define props to accept the books data
const props = defineProps({
    books: {
        type: Object,
        required: true,
    },
});


// initialize components based on data attribute selectors
onMounted(() => {
    initTabs();
})


// Function to update a book
const updateBook = (updatedBook) => {
    const index = books.value.findIndex(book => book.id === updatedBook.id);
    if (index !== -1) {
        books.value[index] = updatedBook;
    }
};


</script>

<template>

    <Head title="Dashboard" />

    <GuestLayout>

        <!-- Page Heading -->
        <template #header>
            <h1 class="text-normal font-semibold text-gray-600">Dashboard</h1>
        </template>

        <div class="max-w-screen-xl mx-auto px-4">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500"
                            id="books-tab" data-tabs-target="#books" type="button" role="tab" aria-controls="books"
                            aria-selected="true">
                            <svg class="w-4 h-4 me-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            Books
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="reviews-tab" data-tabs-target="#reviews" type="button" role="tab"
                            aria-controls="reviews" aria-selected="false">
                            <svg class="w-4 h-4 me-2 inline text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            Reviews
                        </button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden rounded-lg dark:bg-gray-800" id="books" role="tabpanel" aria-labelledby="books-tab">

                    <ListBook :books="props.books" />

                </div>
                <div class="hidden dark:bg-gray-800" id="reviews" role="tabpanel"
                    aria-labelledby="reviews-tab">
                    <ListReview/>

                </div>
            </div>

        </div>
    </GuestLayout>
</template>
