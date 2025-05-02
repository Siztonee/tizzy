<template>
    <aside class="w-full md:w-64 space-y-8">

        <!-- Price Filter -->
        <div class="bg-gray-800 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Цена</h3>
            <div class="space-y-4">
                <input
                    type="range"
                    min="0"
                    max="50000"
                    v-model="minPriceValue"
                    class="w-full"
                />
                <input
                    type="range"
                    min="0"
                    max="50000"
                    v-model="maxPriceValue"
                    class="w-full"
                />
                <div class="flex justify-between text-sm">
                    <span>{{ formatPrice(minPriceValue) }}</span>
                    <span>{{ formatPrice(maxPriceValue) }}</span>
                </div>
            </div>
        </div>

        <!-- Brand Filter -->
        <div class="bg-gray-800 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Бренд</h3>
            <div class="space-y-2">
                <label 
                    v-for="brand in brands" 
                    class="flex items-center space-x-3"
                >
                    <input 
                        type="checkbox"
                        :value="brand.slug"
                        v-model="localFilters.brands"
                        class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                    />
                    <span>{{ brand.name }}</span>
                </label>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="bg-gray-800 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Категория</h3>
            <div class="space-y-2">
                <label 
                    v-for="category in categories" 
                    class="flex items-center space-x-3"
                >
                    <input 
                        type="checkbox"
                        :value="category.slug"
                        v-model="localFilters.categories"
                        class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                    />
                    <span>{{ category.name }}</span>
                </label>
            </div>
        </div>

        <!-- Discount Filter -->
        <div class="bg-gray-800 p-6 rounded-xl">
            <h3 class="font-semibold mb-4">Скидка</h3>
            <input
                type="number"
                min="0"
                max="100"
                v-model="localFilters.discount"
                placeholder="Минимальная скидка"
                class="w-full bg-gray-700 rounded p-2"
            />
        </div>

        <!-- Кнопки действий -->
        <div class="space-y-4">
            <button 
                @click="applyFilters"
                class="w-full py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl"
            >
                Применить фильтры
            </button>
            <button 
                @click="resetFilters"
                class="w-full py-2 text-indigo-400 hover:text-indigo-300"
            >
                Сбросить фильтры
            </button>
        </div>

    </aside>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    filters: Object,
    categories: Array,
    brands: Array,
});

// Инициализация фильтров
const localFilters = ref({
    categories: props.filters.categories || [],   
    brands: props.filters.brands || [],
    min_price: props.filters.min_price || null,
    max_price: props.filters.max_price || null,
    discount: props.filters.discount || null,
    sort: props.filters.sort || null,
});

// Слайдер цены
const minPriceValue = ref(props.filters.min_price || 0);
const maxPriceValue = ref(props.filters.max_price || 50000);

const formatPrice = (value) => {
    return new Intl.NumberFormat('ru-RU').format(value);
};

// Метод для применения фильтров
const applyFilters = () => {
    const params = {
        brands: localFilters.value.brands.join(','),
        categories: localFilters.value.categories.join(','),
        min_price: localFilters.value.min_price || undefined,
        max_price: localFilters.value.max_price || undefined,
        discount: localFilters.value.discount || undefined,
        sort: localFilters.value.sort || undefined,
        page: 1
    };

    // Очистка пустых параметров
    const cleanParams = Object.fromEntries(
        Object.entries(params)
            .filter(([_, v]) => v !== undefined && v !== '')
    );

    router.get('/catalog', cleanParams, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
};

// Сброс фильтров
const resetFilters = () => {
    localFilters.value = {
        categories: [],
        brands: [],
        min_price: null,
        max_price: null,
        discount: null,
        sort: null,
    };
    minPriceValue.value = 0;
    maxPriceValue.value = 50000;
};

// Синхронизация слайдера с фильтрами
watch([minPriceValue, maxPriceValue], ([newMin, newMax]) => {
    localFilters.value.min_price = newMin;
    localFilters.value.max_price = newMax;
});
</script>