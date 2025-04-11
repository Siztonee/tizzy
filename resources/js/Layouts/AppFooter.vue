<script setup>
import { usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const props = defineProps({});
</script>

<template>
    <footer class="bg-gray-800 mt-4">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="#" class="text-gray-300 hover:text-indigo-400">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-gray-300">&copy; 2025 {{ $page.props.appName }}. Все права защищены.</p>
                </div>
            </div>
        </div>
    </footer>
</template>