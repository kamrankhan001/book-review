<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

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
    form.get(route('home'), {
        preserveState: true,
        replace: true, // Keeps URL clean
    });
};

// Function to generate star rating display
const generateStarRating = (rating) => {
    const fullStars = "★".repeat(Math.floor(rating));
    const halfStar = rating % 1 !== 0 ? "½" : "";
    const emptyStars = "☆".repeat(5 - Math.ceil(rating));
    return `${fullStars}${halfStar}${emptyStars}`;
}

</script>

<template>

    <Head title="Home" />

    <Navbar />

    <!-- Search Form -->
    <div class="max-w-screen-xl mx-auto px-6 py-4">
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
    </div>

    <div class="max-w-screen-xl mx-auto p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-items-center">

        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
            v-for="book in props.books.data" :key="book.title">
            <Link :href="route('book-review', book.id)">
            <img class="rounded-t-lg w-full h-48 object-cover" :src="'/storage/' + book.cover_image" alt="Book Cover" />
            </Link>
            <div class="p-5">
                <!-- Book Title -->
                <Link :href="route('book-review', book.id)">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ book.title }}
                </h5>
                </Link>

                <!-- Author Name -->
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">{{ book.author }}</p>

                <!-- Book Description -->
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{ book.description }}
                </p>

                <!-- Five-Star Rating -->
                <div class="flex items-center mb-4">
                    <span class="text-yellow-500">{{ generateStarRating(book.reviews_avg_rating ?? 0) }}</span>
                    <span class="ml-2 text-gray-700">{{ book.reviews_avg_rating ?? 0 }}/5</span>
                </div>

                <!-- Read More Button -->
                <Link :href="route('book-review', book.id)"
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

    <!-- Pagination -->
    <div class="max-w-screen-xl mx-auto mb-2 p-4 flex justify-center bg-white dark:bg-gray-800">
        <nav v-if="props.books.links.length > 3" aria-label="Pagination" class="mt-4">
            <ul class="inline-flex -space-x-px text-sm">
                <li v-for="(link, index) in props.books.links" :key="index">
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
