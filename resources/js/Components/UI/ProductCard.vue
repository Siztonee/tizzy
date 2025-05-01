<template>
    <div class="bg-gray-800 rounded-xl p-6 hover:scale-[1.02] transition-all flex flex-col h-full">
        <!-- Изображение товара с фиксированной высотой -->
        <div class="aspect-[4/3] mb-4 relative">
            <img
            :src="shoe.image"
            :alt="shoe.name"
            class="w-full h-full object-cover rounded-lg"
            />
            
        </div>

        <!-- Информация о товаре -->
        <div class="flex flex-col flex-grow">
            <!-- Название товара с фиксированной высотой -->
            <h3 class="font-semibold text-lg h-14 line-clamp-2">{{ shoe.name }}</h3>

            <!-- Рейтинг -->
            <div class="flex items-center space-x-1 text-yellow-400 mb-2">
            <div class="flex items-center">
                <span class="text-sm mr-2">{{ shoe.rating }}</span>
                <div class="flex">
                <StarIcon v-for="i in 5" :key="i" 
                        class="w-4 h-4"
                        :class="i <= Math.round(shoe.rating) 
                        ? 'text-yellow-400 fill-current' 
                        : 'text-gray-600'"/>
                </div>
            </div>
            </div>

            <!-- Описание с фиксированной высотой -->
            <p class="text-gray-400 text-sm h-10 mb-4 line-clamp-2">
            {{ shoe.description }}
            </p>

            <!-- Цена внизу карточки -->
            <div class="mt-auto">
            <div class="flex items-center">
                <span class="text-xl font-bold">
                {{ shoe.discounted_price ? shoe.discounted_price : shoe.price }}
                </span>
                <span
                v-if="shoe.discounted_price"
                class="ml-2 text-gray-400 line-through"
                >
                {{ shoe.price }}
                </span>
            </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { StarIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  shoe: Array,
});

</script>