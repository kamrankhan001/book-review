<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <div class="py-16">
            <div class="flex bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
                <div class="hidden lg:block lg:w-1/2 bg-cover bg-center" style="background-image:url('/imgs/book1.jpg')"></div>
                <div class="w-full p-8 lg:w-1/2">
                    <div class="text-center text-gray-600 font-bold text-lg mb-4">Sign Up</div>
                    <form @submit.prevent="submit">
                        <!-- Name Field -->
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input id="name" type="text" v-model="form.name" autocomplete="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- Email Field -->
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input id="email" type="email" v-model="form.email" autocomplete="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input id="password" type="password" v-model="form.password" autocomplete="new-password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-5">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                            <input id="password_confirmation" type="password" v-model="form.password_confirmation"
                                autocomplete="new-password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                :disabled="form.processing">
                                Register
                            </button>
                        </div>

                        <!-- Already Registered -->
                        <div class="mt-4 flex items-center justify-between">
                            <span class="border-b w-1/5 md:w-1/4"></span>
                            <Link :href="route('login')" class="text-xs text-blue-600 hover:text-blue-800 uppercase">
                                Sign in
                            </Link>
                            <span class="border-b w-1/5 md:w-1/4"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
