<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';

const book = ref({
    title: "The Great Gatsby",
    author: "F. Scott Fitzgerald",
    cover: "/imgs/book1.jpg", // Replace with actual book cover URL
    description:
        "The Great Gatsby is a 1925 novel by American writer F. Scott Fitzgerald. Set in the Jazz Age on Long Island, the novel depicts narrator Nick Carraway's interactions with mysterious millionaire Jay Gatsby and Gatsby's obsession to reunite with his former lover, Daisy Buchanan.",
});

const reviews = ref([
    {
        id: 1,
        user: {
            name: "John Doe",
            image: "/person.png",
        },
        published_date: "2023-10-01",
        rating: 4.5,
        review:
            "A timeless classic! The characters are well-developed, and the story is captivating.",
    },
    {
        id: 2,
        user: {
            name: "Jane Smith",
            image: "/person.png",
        },
        published_date: "2023-09-25",
        rating: 5,
        review:
            "Absolutely loved it! The writing is beautiful, and the themes are still relevant today.",
    },
    {
        id: 3,
        user: {
            name: "Alice Johnson",
            image: "/person.png",
        },
        published_date: "2023-09-15",
        rating: 3.5,
        review:
            "A good read, but I found some parts a bit slow. Still worth it for the ending!",
    },
]);

// Function to format date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

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
                    <img :src="book.cover" alt="Book Cover" class="w-48 h-64 object-cover rounded-lg shadow-md" />
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
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews</h2>
            <!-- Review List -->
            <div v-for="review in reviews" :key="review.id" class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex items-center">
                    <!-- Reviewer Image -->
                    <img :src="review.user.image" alt="User Image" class="w-10 h-10 rounded-full object-cover" />
                    <!-- Reviewer Name and Date -->
                    <div class="ml-4">
                        <p class="text-gray-900 font-semibold">{{ review.user.name }}</p>
                        <p class="text-gray-500 text-sm">{{ formatDate(review.published_date) }}</p>
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
