<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AddReview from './AddReview.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';


// Props to accept the book data
const props = defineProps({
    book: {
        type: Object,
        required: true,
    },
});


const book = ref(props.book);


// Function to generate star rating display
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
        <div class="bg-white border rounded-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row">
                <!-- Book Cover -->
                <div class="md:w-1/4 flex justify-center">
                    <img :src="'/storage/'+book.cover_image" alt="Book Cover" class="w-48 h-64 object-cover rounded-lg shadow-md" />
                </div>
                <!-- Book Info -->
                <div class="md:w-3/4 md:pl-8 mt-6 md:mt-0">
                    <h1 class="text-3xl font-bold text-gray-900">{{ book.title }}</h1>
                    <p class="text-gray-600 text-lg mt-2">by {{ book.author }}</p>
                    <p class="text-gray-700 mt-4">{{ book.description }}</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->

        <div v-if="usePage().props.auth.user">
            <AddReview :bookId="book.id"/>
        </div>

        <div v-else>
            <div class="bg-yellow-300 border rounded-lg p-6 mb-6">
                <p class="text-gray-700">Please login to add a review.</p>
            </div>
        </div>

        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews</h2>
            <!-- Review List -->
            <div v-for="review in book.reviews" :key="review.id" class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex items-center">
                    <!-- Reviewer Image -->
                    <img src="/person.png" alt="User Image" class="w-10 h-10 rounded-full object-cover" />
                    <!-- Reviewer Name and Date -->
                    <div class="ml-4">
                        <p class="text-gray-900 font-semibold">{{ review.user.name }}</p>
                        <p class="text-gray-500 text-sm">{{review.created_at}}</p>
                    </div>
                </div>
                <!-- Rating -->
                <div class="mt-4 flex items-center">
                    <span class="text-yellow-500">{{ generateStarRating(review.rating) }}</span>
                    <span class="ml-2 text-gray-700">{{ review.rating }}/5</span>
                </div>
                <!-- Review Text -->
                <p class="text-gray-700 mt-4">{{ review.review }}</p>
            </div>
        </div>
    </div>

</GuestLayout>

</template>
