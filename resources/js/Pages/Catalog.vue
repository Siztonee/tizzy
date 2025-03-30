<template>
  <CustomHead title="Каталог" />

  <AppLayout>
    <div class="min-h-screen bg-gray-900 text-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div
          class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4"
        >
          <h1 class="text-3xl font-bold">Каталог обуви</h1>
          <div class="w-full md:w-64">
            <select
              v-model="selectedSort"
              class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:ring-2 focus:ring-indigo-500"
            >
              <option value="newest">Сначала новинки</option>
              <option value="price_asc">По возрастанию цены</option>
              <option value="price_desc">По убыванию цены</option>
              <option value="popular">По популярности</option>
              <option value="rating">По рейтингу</option>
            </select>
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
          <aside class="w-full md:w-64 space-y-8">
            <div class="bg-gray-800 p-6 rounded-xl">
              <h3 class="font-semibold mb-4">Цена</h3>
              <div class="space-y-4">
                <input
                  type="range"
                  min="0"
                  max="50000"
                  value="25000"
                  class="w-full"
                  @input="updatePriceDisplay"
                />
                <div class="flex justify-between text-sm">
                  <span ref="minPrice">0</span>
                  <span ref="maxPrice">50 000</span>
                </div>
              </div>
            </div>
            <!-- Фильтр по брендам -->
            <div class="bg-gray-800 p-6 rounded-xl">
              <h3 class="font-semibold mb-4">Бренд</h3>
              <div class="space-y-2">
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>Nike</span>
                </label>
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>Adidas</span>
                </label>
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>Puma</span>
                </label>
              </div>
            </div>

            <!-- Фильтр по рейтингу -->
            <div class="bg-gray-800 p-6 rounded-xl">
              <h3 class="font-semibold mb-4">Рейтинг</h3>
              <div class="space-y-2">
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>4.5+</span>
                </label>
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>4.0 - 4.5</span>
                </label>
                <label class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    class="rounded bg-gray-700 border-gray-600 text-indigo-500"
                  />
                  <span>3.0 - 4.0</span>
                </label>
              </div>
            </div>

            <!-- Фильтр по скидке -->
            <div class="bg-gray-800 p-6 rounded-xl">
              <h3 class="font-semibold mb-4">Скидка</h3>
              <div class="flex flex-wrap gap-2">
                <button
                  class="px-2 py-1 rounded-full bg-red-500 border-2 border-transparent hover:border-white"
                >
                  20%
                </button>
                <button
                  class="px-2 py-1 rounded-full bg-red-500 border-2 border-transparent hover:border-white"
                >
                  40%
                </button>
                <button
                  class="px-2 py-1 rounded-full bg-red-500 border-2 border-transparent hover:border-white"
                >
                  60%
                </button>
                <button
                  class="px-2 py-1 rounded-full bg-red-500 border-2 border-transparent hover:border-white"
                >
                  80%
                </button>
              </div>
            </div>

            <button class="w-full py-2 text-indigo-400 hover:text-indigo-300">
              Сбросить фильтры
            </button>
          </aside>

          <div class="flex-1">
            <!-- Сетка товаров -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="shoe in items"
                :key="shoe.id"
                class="bg-gray-800 rounded-xl p-6 hover:scale-[1.02] transition-all flex flex-col h-full"
              >
                <!-- Изображение товара с фиксированной высотой -->
                <div class="aspect-[4/3] mb-4 relative">
                  <img
                    :src="`https://picsum.photos/200/300?random=${shoe.image}`"
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
                    {{ shoe.rating }}
                  </div>

                  <!-- Описание с фиксированной высотой -->
                  <p class="text-gray-400 text-sm h-10 mb-4 line-clamp-2">
                    {{ shoe.description }}
                  </p>

                  <!-- Цена внизу карточки -->
                  <div class="mt-auto">
                    <div class="flex items-center">
                      <span class="text-xl font-bold">
                        {{ shoe.discount_price ? shoe.discount_price : shoe.price }}
                      </span>
                      <span
                        v-if="shoe.discount_price"
                        class="ml-2 text-gray-400 line-through"
                      >
                        {{ shoe.price }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Кнопка "Показать еще" -->
            <div v-if="nextPageUrl" class="flex justify-center mt-12">
              <button
                @click="loadMore"
                class="px-6 py-2 bg-gray-800 hover:bg-gray-700 rounded-full"
                :disabled="loading"
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
import CustomHead from '@/Components/CustomHead.vue';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  shoes: Object,
});

const selectedSort = ref('newest');
const items = ref(props.shoes.data || []);
const nextPageUrl = ref(props.shoes.next_page_url || null);
const loading = ref(false);

const loadMore = async () => {
  if (!nextPageUrl.value || loading.value) return;

  loading.value = true;
  try {
    const url = new URL(nextPageUrl.value);
    const page = url.searchParams.get('page');

    const response = await fetch(`/catalog/load-more?page=${page}`);

    if (!response.ok) {
      throw new Error('Ошибка сети: ' + response.status);
    }

    const data = await response.json();

    if (data.data && Array.isArray(data.data)) {
      items.value = [...items.value, ...data.data];
      nextPageUrl.value = data.next_page_url;
    } else {
      console.error('Некорректный формат данных:', data);
    }
  } catch (error) {
    console.error('Ошибка загрузки данных:', error);
  } finally {
    loading.value = false;
  }
};

const updatePriceDisplay = (event) => {
  const minPrice = document.querySelector('[ref="minPrice"]');
  const maxPrice = document.querySelector('[ref="maxPrice"]');

  if (minPrice && maxPrice) {
    minPrice.innerText = event.target.min;
    maxPrice.innerText = event.target.value;
  }
};
</script>