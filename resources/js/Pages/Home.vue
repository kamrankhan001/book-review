<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';

const books = ref([
    {
        title: 'The Great Gatsby',
        author: 'F. Scott Fitzgerald',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book1.jpg',
        rating: 5,
    },
    {
        title: 'To Kill a Mockingbird',
        author: 'Harper Lee',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book2.jpg',
        rating: 4,
    },
    {
        title: '1984',
        author: 'George Orwell',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book3.jpg',
        rating: 3,
    },
    {
        title: 'Pride and Prejudice',
        author: 'Jane Austen',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book4.jpg',
        rating: 4,
    },
    {
        title: 'The Catcher in the Rye',
        author: 'J.D. Salinger',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book5.jpg',
        rating: 5,
    },
    {
        title: 'Animal Farm',
        author: 'George Orwell',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        cover: '/imgs/book6.jpg',
        rating: 4,
    },
]);

</script>

<template>

    <Head title="Home" />

    <Navbar />

    <div class="max-w-screen-xl mx-auto p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
            v-for="book in books" :key="book.title">
            <a href="#">
                <img class="rounded-t-lg w-full h-48 object-cover" :src="book.cover" alt="Book Cover" />
            </a>
            <div class="p-5">
                <!-- Book Title -->
                <Link :href="route('book-review', book.title)">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ book.title }}
                    </h5>
                </Link>

                <!-- Author Name -->
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">{{ book.auther }}</p>

                <!-- Book Description -->
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{ book.description }}
                </p>

                <!-- Five-Star Rating -->
                <div class="flex items-center mb-4">
                    <!-- Full Stars -->
                    <template v-for="star in 5" :key="star">
                        <!-- Full Star -->
                        <svg v-if="star <= Math.floor(book.rating)" class="w-4 h-4 text-yellow-300 me-1"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <!-- Half Star -->
                        <svg v-else-if="star === Math.floor(book.rating) + 1 && book.rating % 1 !== 0"
                            class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <!-- Empty Star -->
                        <svg v-else class="w-4 h-4 text-gray-300 me-1 dark:text-gray-500" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                    </template>
                    <!-- Rating Text -->
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ book.rating }} out of 5</span>
                </div>

                <!-- Read More Button -->
                <Link :href="route('book-review', book.title)"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
                </Link>
            </div>
        </div>
    </div>


</template>
