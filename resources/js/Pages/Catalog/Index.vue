<template>
  <AppTitle title="Каталог" />

  <AppLayout>
    <div class="min-h-screen bg-gray-900 text-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div
          class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4"
        >
          <h1 class="text-3xl font-bold">Каталог обуви</h1>
          
          <ProductSorts />

        </div>

        <div class="flex flex-col md:flex-row gap-8">

          <!-- Filters -->
          <ProductFilters 
            :filters="filters"
            :categories="categories" 
            :brands="brands"
          />

          <div class="flex-1">
            <!-- Сетка товаров -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              <ProductCard v-for="shoe in items" :shoe="shoe" :key="shoe.id" />
            </div>

            <!-- Кнопка "Показать еще" -->
            <div v-if="nextPageUrl" class="flex justify-center mt-12">
              <button
                @click="loadMore"
                class="px-6 py-2 bg-gray-800 hover:bg-gray-700 rounded-full"
                :disabled="loading"
                :preserve-state="true"
              >
                {{ loading ? "Загрузка..." : "Показать еще" }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppTitle from '@/Components/App/AppTitle.vue';
import { ref, onMounted, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import ProductFilters from '@/Pages/Catalog/Components/ProductFilters.vue';
import ProductSorts from '@/Pages/Catalog/Components/ProductSorts.vue';
import ProductCard from '@/Components/UI/ProductCard.vue';

const props = defineProps({
    shoes: Object,
    filters: Object,
    brands: Array,
    categories: Array,
});

// Реактивные данные
const items = ref(props.shoes.data);
const nextPageUrl = ref(props.shoes.links.next);
const loading = ref(false);

// Следим за изменением пропсов
watch(() => props.shoes, (newShoes) => {
    items.value = newShoes.data;
    nextPageUrl.value = newShoes.links.next;
});

// Загрузка через Inertia
const loadMore = () => {
    if (!nextPageUrl.value || loading.value) return;
    
    loading.value = true;
    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            items.value = [...items.value, ...props.shoes.data];
            nextPageUrl.value = props.shoes.links.next;
            loading.value = false;
        },
        onError: () => {
            loading.value = false;
        }
    });
};


</script>