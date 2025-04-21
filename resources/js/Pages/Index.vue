<template>
    <AppTitle title="Главная" />
    <AppLayout>
        <div class="relative bg-gray-800">
            <div class="max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                        <span class="block text-indigo-400">Новая коллекция обуви</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Откройте для себя идеальное сочетание стиля и комфорта
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <Link :href="route('catalog')" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            В каталог
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Популярные товары -->
        <section class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-8">Популярное</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Карточка товара -->
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:transform hover:scale-105 transition-transform duration-200">
                    <img src="https://placehold.jp/600x400.png" alt="Кроссовки" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold">Nike Air Max 270</h3>
                            <div class="text-indigo-400" data-rating="4">
                                <!-- Звезды будут добавлены через JS -->
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-xl font-bold">12 499 ₽</span>
                            <span class="ml-2 text-gray-400 line-through">14 999 ₽</span>
                        </div>
                    </div>
                </div>

                <!-- Еще карточки товаров... -->
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppTitle from '@/Components/App/AppTitle.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({});
</script>