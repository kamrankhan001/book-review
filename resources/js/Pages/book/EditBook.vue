<script setup>
import InputError from '@/Components/InputError.vue';
import { ref, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { initModals, Modal } from 'flowbite';
import { toast } from 'vue3-toastify';

// Props to accept the book data
const props = defineProps({
    book: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    initModals();
});

// Initialize the form with the book data
const form = useForm({
    id: props.book.id,
    title: props.book.title,
    author: props.book.author,
    cover_image: null,
    description: props.book.description,
});

// Function to handle image selection and preview
const coverImagePreview = ref(props.book.cover_image || null);

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            coverImagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const showModal = (id) => {
    const modalElement = document.getElementById(`edit-modal-${id}`);
    const modal = new Modal(modalElement);
    modal.show();
};

const hideModal = (id) => {
    const modalElement = document.getElementById(`edit-modal-${id}`);
    const modal = new Modal(modalElement);
    modal.hide();
};

// Function to submit the form
const submitForm = (id) => {
    form.post(route('books.update', props.book.id), {
        preserveScroll: true,
        onSuccess: () => {
            hideModal(id);
            toast.success(usePage().props.flash.message);
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
</script>

<template>
    <!-- Modal toggle -->
    <button :data-modal-target="`edit-modal-${book.id}`" :data-modal-toggle="`edit-modal-${book.id}`"
        @click="() => showModal(book.id)"
        class="px-3 py-1 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 mb-2" type="button">
        Edit
    </button>

    <!-- Main modal -->
    <div :id="`edit-modal-${book.id}`" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Book
                    </h3>
                    <button type="button" @click="() => hideModal(book.id)"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        :data-modal-toggle="`edit-modal-${book.id}`">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="() => submitForm(book.id)" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book
                                Title</label>
                            <input type="text" v-model="form.title" id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter book title" required>
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="col-span-2">
                            <label for="author"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author Name</label>
                            <input type="text" v-model="form.author" id="author"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Enter author name" required>
                            <InputError class="mt-2" :message="form.errors.author" />
                        </div>
                        <div class="col-span-2">
                            <label for="cover_image"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book Cover
                                Image</label>
                            <input type="file" @change="handleImageChange" :id="`cover_image-${book.id}`"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                accept="image/*">
                            <InputError class="mt-2" :message="form.errors.cover_image" />
                            <img v-if="coverImagePreview"
                                :src="coverImagePreview.startsWith('data:') ? coverImagePreview : `/storage/${coverImagePreview}`"
                                alt="Book Cover Preview" class="mt-2 w-32 h-32 object-cover rounded-lg">
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea v-model="form.description" id="description" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write book description here"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
