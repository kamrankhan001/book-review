<script setup>
import EditReview from './EditReview.vue';
import DeleteReview from './DeleteReview.vue';
import CreateReview from './CreateReview.vue';

import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

// Define props to accept the books data
const props = defineProps({
    reviews: {
        type: Object,
        required: true,
    },
});

// Toggle state
const showOnlyMyBooks = ref(false);

// Filtered reviews based on the toggle
const filteredReviews = computed(() => {
    if (showOnlyMyBooks.value) {
        return props.reviews.filter(review => review.book.user_id === usePage().props.auth.user.id);
    }
    return props.reviews;
});

const generateStarRating = (rating) => {
    const fullStars = "★".repeat(Math.floor(rating));
    const halfStar = rating % 1 !== 0 ? "½" : "";
    const emptyStars = "☆".repeat(5 - Math.ceil(rating));
    return `${fullStars}${halfStar}${emptyStars}`;
}
</script>

<template>

    <div class="flex justify-between">
        <div>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="showOnlyMyBooks" class="sr-only peer" />
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                </div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Only my books</span>
            </label>
        </div>
        <div>
            <CreateReview />
        </div>
    </div>

    <div v-if="props.reviews.length === 0" class="text-center text-gray-500 dark:text-gray-400 border py-4 mt-2">
        No reviews found.
    </div>

    <div v-else class="space-y-4 border mb-2" v-for="review in filteredReviews" :key="review.id">
        <div class="flex px-4 bg-white dark:bg-gray-900">
            <img :src="'/storage/' + review.book.cover_image" alt="Book Cover"
                class="w-24 h-32 object-cover rounded-lg">
            <div class="ml-4 flex-1">
                <Link :href="route('book-review', review.book.id)"
                    class="text-lg font-semibold text-gray-800 dark:text-white">{{ review.book.title }}</Link>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ review.review }}
                </p>
                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                    Published on: {{ review.created_at }}
                </p>
                <!-- Rating -->
                <div class="mt-4 flex items-center">
                    <span class="text-yellow-500">{{ generateStarRating(review.rating) }}</span>
                    <span class="ml-2 text-gray-700">{{ review.rating }}/5</span>
                </div>
            </div>
        </div>
        <div class="me-2 flex space-x-2 justify-end">
            <EditReview :review="review" />
            <DeleteReview :review="review" />
        </div>
    </div>



</template>
