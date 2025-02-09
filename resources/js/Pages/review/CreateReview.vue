<script setup>
import InputError from '@/Components/InputError.vue';
import { onMounted, inject } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { initModals, Modal } from 'flowbite';
import { toast } from 'vue3-toastify';


const books = inject('books');


onMounted(() => {
    initModals();
});


// Define the form fields
const form = useForm({
    user_id: usePage().props.auth.user?.id,
    book_id: '',
    review: '',
    rating: '',
});

const showModal = () => {
    const modalElement = document.getElementById('add-review-modal');
    const modal = new Modal(modalElement);
    modal.show();
};

const hideModal = () => {
    const modalElement = document.getElementById('add-review-modal');
    const modal = new Modal(modalElement);
    modal.hide();
};

// Function to submit the form
const submitForm = () => {
    form.post(route('book-review.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Reset the form after successful submission
            form.reset();
            hideModal();
            if(usePage().props.flash.message == 'yes'){
                toast.error("you are already reviewed this book");
            }else{
                toast.success(usePage().props.flash.message);
            }
        },
    });
};
</script>

<template>
    <!-- Modal toggle -->
    <div class="text-end">
        <button data-modal-target="add-review-modal" data-modal-toggle="add-review-modal" @click="showModal"
            class="p-3 py-1 text-normal text-white bg-blue-600 rounded-lg hover:bg-blue-700 mb-2" type="button">
            Add Review
        </button>
    </div>

    <!-- Main modal -->
    <div id="add-review-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add Review
                    </h3>
                    <button type="button" @click="hideModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="add-review-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="submitForm" class="p-4 md:p-5">
                    <!-- User ID -->
                    <div>
                        <input type="hidden" v-model="form.user_id" id="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter user ID" required />
                        <InputError class="mt-2" :message="form.errors.user_id" />
                    </div>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="book_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Select Book
                            </label>
                            <select v-model="form.book_id" id="book_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose a book</option>
                                <option v-for="book in books.data" :key="book.id" :value="book.id">
                                    {{ book.title }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.book_id" />
                        </div>

                        <!-- Review -->
                        <div class="col-span-2">
                            <label for="review"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Review</label>
                            <textarea v-model="form.review" id="review" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write your review here"></textarea>
                            <InputError class="mt-2" :message="form.errors.review" />
                        </div>

                        <!-- Rating -->
                        <div class="col-span-2">
                            <label for="rating"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rating</label>
                            <input type="number" v-model="form.rating" id="rating" step="0.1" min="1" max="5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter rating (1.0 - 5.0)" required />
                            <InputError class="mt-2" :message="form.errors.rating" />
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
