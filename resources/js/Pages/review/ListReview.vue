<script setup>
const generateStarRating = (rating) => {
    const fullStars = "★".repeat(Math.floor(rating));
    const halfStar = rating % 1 !== 0 ? "½" : "";
    const emptyStars = "☆".repeat(5 - Math.ceil(rating));
    return `${fullStars}${halfStar}${emptyStars}`;
}
</script>

<template>
    <div class="space-y-4 border mb-2">
        <div class="flex px-4 bg-white dark:bg-gray-900">
            <img src="/imgs/book1.jpg" alt="Book Cover" class="w-24 h-32 object-cover rounded-lg">
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Book Title</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam porro ullam, cum modi excepturi consequuntur iure, error voluptates vero, maiores sapiente iste asperiores aspernatur dicta. Aliquam atque necessitatibus neque quidem!
                </p>
                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                    Published on: January 15, 2024
                </p>
                <!-- Rating -->
                <div class="mt-4 flex items-center">
                    <span class="text-yellow-500">{{ generateStarRating(5) }}</span>
                    <span class="ml-2 text-gray-700">{{ 5 }}/5</span>
                </div>
            </div>
        </div> 
        <div class="me-2 flex space-x-2 justify-end">
            <button class="px-3 py-1 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 mb-2">Edit</button>
            <button class="px-3 py-1 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 mb-2">Delete</button>
        </div>
    </div>
</template>
