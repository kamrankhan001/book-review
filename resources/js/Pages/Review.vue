<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AddReview from './AddReview.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    book: {
        type: Object,
        required: true,
    },
});

const book = ref(props.book);

const generateStarRating = (rating) => {
    const fullStars = "★".repeat(Math.floor(rating));
    const halfStar = rating % 1 !== 0 ? "½" : "";
    const emptyStars = "☆".repeat(5 - Math.ceil(rating));
    return `${fullStars}${halfStar}${emptyStars}`;
}
</script>

<template>
    <GuestLayout>
        <Head title="BookReview" />

        <div class="max-w-screen-xl mx-auto p-4">
            <!-- Book Details Section -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-8 shadow-sm dark:shadow-gray-900/20">
                <div class="flex flex-col md:flex-row">
                    <!-- Book Cover -->
                    <div class="md:w-1/4 flex justify-center">
                        <img :src="'/storage/' + book.cover_image" alt="Book Cover"
                            class="w-48 h-64 object-cover rounded-lg shadow-md" />
                    </div>
                    <!-- Book Info -->
                    <div class="md:w-3/4 md:pl-8 mt-6 md:mt-0">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ book.title }}</h1>
                        <p class="text-gray-600 dark:text-gray-300 text-lg mt-2">by {{ book.author }}</p>
                        <p class="text-gray-700 dark:text-gray-300 mt-4">{{ book.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div v-if="usePage().props.auth.user">
                <AddReview :bookId="book.id" />
            </div>

            <div v-else>
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-6">
                    <p class="text-gray-700 dark:text-yellow-200">Please login to add a review.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm dark:shadow-gray-900/20" v-if="book.reviews.length > 0">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Reviews</h2>
                <!-- Review List -->
                <div v-for="review in book.reviews" :key="review.id" class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 last:border-0 last:mb-0 last:pb-0">
                    <div class="flex items-center">
                        <!-- Reviewer Image -->
                        <img src="/person.png" alt="User Image" class="w-10 h-10 rounded-full object-cover" />
                        <!-- Reviewer Name and Date -->
                        <div class="ml-4">
                            <p class="text-gray-900 dark:text-white font-semibold">{{ review.user.name }}</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ review.created_at }}</p>
                        </div>
                    </div>
                    <!-- Rating -->
                    <div class="mt-4 flex items-center">
                        <span class="text-yellow-500">{{ generateStarRating(review.rating) }}</span>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ review.rating }}/5</span>
                    </div>
                    <!-- Review Text -->
                    <p class="text-gray-700 dark:text-gray-300 mt-4">{{ review.review }}</p>
                </div>
            </div>

            <div v-else>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm dark:shadow-gray-900/20">
                    <p class="text-gray-700 dark:text-gray-300 text-center">No reviews available for this book.</p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>