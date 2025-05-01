<template>
    <aside class="w-full md:w-64 space-y-8">
        <!-- Индикатор количества выбранных фильтров -->
        <div class="text-sm text-gray-400 mb-2">
            Выбрано брендов: {{ localFilters.brands.length }}
        </div>

        <!-- Чипсы выбранных фильтров -->
        <div class="flex flex-wrap gap-2 mb-4">
            <div 
                v-for="brand in localFilters.brands"
                class="px-2 py-1 bg-indigo-500 rounded-full text-sm"
            >
                {{ brands.find(b => b.id === brand)?.name }}
                <button @click="localFilters.brands = localFilters.brands.filter(b => b !== brand)">
                    ×
                </button>
            </div>
        </div>

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
                        :value="brand.id"
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
                        :value="category.id"
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

        <button 
            @click="resetFilters"
            class="w-full py-2 text-indigo-400 hover:text-indigo-300"
        >
            Сбросить фильтры
        </button>
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
    min_price: props.filters.min_price || undefined,
    max_price: props.filters.max_price || undefined,
    discount: props.filters.discount || undefined,
    sort: props.filters.sort || null,
});

// Слайдер цены
const minPriceValue = ref(0);
const maxPriceValue = ref(50000);

const formatPrice = (value) => {
    return new Intl.NumberFormat('ru-RU').format(value);
};

watch([minPriceValue, maxPriceValue], ([newMin, newMax]) => {
    localFilters.value.min_price = newMin;
    localFilters.value.max_price = newMax;
});

// Дебаунс фильтров
let debounceTimer = null;

watch(localFilters, (newFilters) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        router.get('/catalog', {
            ...newFilters,
            categories: newFilters.categories.length ? newFilters.categories : undefined,
            brands: newFilters.brands.length ? newFilters.brands : undefined,
        }, {
            preserveState: true,
            replace: true,
        });
    }, 400);
}, { deep: true });

const resetFilters = () => {
    localFilters.value = {
        categories: [],
        brands: [],
        min_price: undefined,
        max_price: undefined,
        discount: undefined,
        sort: null,
    };
    minPriceValue.value = 0;
    maxPriceValue.value = 50000;
};
</script>
