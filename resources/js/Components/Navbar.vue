<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue'
import { initDropdowns } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initDropdowns();
})
</script>

<template>
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <Link :href="route('home')" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/books.png" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Books Review</span>
            </Link>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <template v-if="$page.props.auth.user">

                        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                            class="flex items-center text-sm pe-1 font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                            type="button">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 me-2 rounded-full" src="/person.png"
                                alt="user photo">
                            {{$page.props.auth.user.name}}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAvatarName"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                                <li>
                                    <Link :href="route('dashboard')"
                                        :class="{
                                            'block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white': true,
                                            'bg-gray-100 dark:bg-gray-600 dark:text-white': route().current('dashboard')
                                        }">
                                        Dashboard</Link>
                                </li>
                                <li>
                                    <Link :href="route('profile.edit')"
                                        :class="{
                                            'block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white': true,
                                            'bg-gray-100 dark:bg-gray-600 dark:text-white': route().current('profile.edit')
                                        }">
                                        Settings</Link>
                                </li>
                            </ul>
                            <div class="py-2">
                                <Link :href="route('logout')" method="post"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white w-full text-start">Sign
                                    out</Link>
                            </div>
                        </div>

                    </template>

                    <template v-else>
                        <li>
                            <Link :href="route('login')" :class="{
                                'block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent': true,
                                'text-blue-700 dark:text-blue-500': route().current('login')
                            }">
                            Login
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('register')" :class="{
                                'block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent': true,
                                'text-blue-700 dark:text-blue-500': route().current('register')
                            }">
                            Register
                            </Link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>
