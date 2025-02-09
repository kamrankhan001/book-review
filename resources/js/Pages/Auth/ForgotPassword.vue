<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="py-16">
            <div class="flex bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
                <div class="hidden lg:block lg:w-1/2 bg-cover" style="background-image:url('/imgs/book1.jpg')">
                </div>
                <div class="w-full p-8 lg:w-1/2">
                    <div class="text-center text-gray-600 font-bold text-lg mb-4">Forgot Password</div>

                    <div class="mb-4 text-sm text-gray-600">
                        Forgot your password? No problem. Just let us know your email
                        address and we will email you a password reset link that will allow
                        you to choose a new one.
                    </div>

                    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Your email
                            </label>
                            <input id="email" type="email" v-model="form.email" autofocus autocomplete="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                :disabled="form.processing">
                                Email Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
