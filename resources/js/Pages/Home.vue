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
        replace: true,
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

    <main class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Search Form -->
            <div class="py-6 max-w-2xl mx-auto">
                <form @submit.prevent="searchBook" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="search"
                        v-model="form.search"
                        @input="searchBook"
                        class="block w-full pl-12 pr-4 py-3 rounded-xl border-0 bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-300 dark:ring-gray-700 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-900 dark:text-gray-100 transition-all duration-200"
                        placeholder="Search books, authors..."
                        required
                    />
                </form>
            </div>

            <!-- Book Grid -->
            <div v-if="props.books.data.length > 0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div 
                        v-for="book in props.books.data" 
                        :key="book.id"
                        class="group relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl dark:shadow-gray-900/30 transition-all duration-300 hover:-translate-y-1"
                    >
                        <!-- Rating Badge -->
                        <div class="absolute top-3 right-3 z-10 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 text-xs font-semibold px-2.5 py-1 rounded-full shadow">
                            {{ book.reviews_avg_rating ? book.reviews_avg_rating.toFixed(1) : '0.0' }}/5
                        </div>

                        <!-- Book Cover -->
                        <Link :href="route('book-review', book.id)">
                            <div class="relative h-64 overflow-hidden">
                                <img 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                    :src="'/storage/' + book.cover_image" 
                                    alt="Book Cover"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </Link>

                        <!-- Book Details -->
                        <div class="p-5">
                            <!-- Title and Author -->
                            <div class="mb-3">
                                <Link :href="route('book-review', book.id)">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ book.title }}
                                    </h3>
                                </Link>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ book.author }}</p>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                {{ book.description }}
                            </p>

                            <!-- Rating and Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-yellow-500 mr-1 text-sm">{{ generateStarRating(book.reviews_avg_rating ?? 0) }}</span>
                                </div>
                                <Link 
                                    :href="route('book-review', book.id)"
                                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors flex items-center"
                                >
                                    Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="py-16 text-center">
                <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-md dark:shadow-gray-900/30">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-50 dark:bg-gray-700 mb-4">
                        <svg class="h-8 w-8 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">No books found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Try adjusting your search or filters to find what you're looking for.</p>
                    <button 
                        @click="form.search = ''; searchBook()"
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors"
                    >
                        Clear search
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav v-if="props.books.links.length > 3" aria-label="Pagination">
                    <ul class="inline-flex items-center space-x-1">
                        <li v-for="(link, index) in props.books.links" :key="index">
                            <button 
                                @click="goToPage(link.url)" 
                                v-html="link.label"
                                :disabled="!link.url"
                                :class="[
                                    'px-4 py-2 text-sm font-medium rounded-md',
                                    link.active 
                                        ? 'bg-blue-600 text-white border border-blue-600'
                                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700',
                                    index === 0 ? 'rounded-l-md' : '',
                                    index === books.links.length - 1 ? 'rounded-r-md' : '',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
                                ]"
                            ></button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</template>