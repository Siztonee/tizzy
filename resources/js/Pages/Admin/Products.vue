<template>
  <CustomHead title="Админ панель" />
  <AppLayout>
    <PanelHeader />
    <div class="h-full flex flex-col bg-gray-900 rounded-xl shadow mb-12 p-6 lg:p-8">
      <!-- Заголовок и кнопки -->
      <div class="mb-8 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Управление товарами</h2>
        <Link :href="route('admin.products')"
              class="text-xl font-semibold text-white">
          + Добавить товар
        </Link>
      </div>

      <!-- Счетчик товаров для отладки -->
      <div class="mb-4 text-sm text-gray-400">
        Отображается {{ productsList.length }} из {{ totalCount }} товаров
      </div>

      <!-- Контейнер таблицы -->
      <div class="flex-1 overflow-hidden relative">
        <div class="h-[calc(150vh-270px)] overflow-y-auto rounded-md" ref="scrollContainer">
          <!-- Таблица -->
          <table class="w-full relative">
            <thead class="sticky top-0 bg-gray-800 z-10">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Изображение</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Цена</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Остаток</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Рейтинг</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Скидка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"></th>
              </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-700">
              <tr v-for="product in productsList" :key="product.id" 
                  class="hover:bg-gray-800 transition-colors">
                <!-- ID -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-300">
                  #{{ product.id }}
                </td>
                
                <!-- Изображение -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-700">
                    <img v-if="product.image" :src="product.image" 
                        class="w-full h-full object-cover" 
                        alt="Изображение товара">
                    <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                      <PhotoIcon class="w-6 h-6"/>
                    </div>
                  </div>
                </td>
                
                <!-- Название -->
                <td class="px-6 py-4 max-w-xs">
                  <div class="text-sm font-medium text-white">
                    {{ product.name }}
                  </div>
                  <div v-if="product.category" 
                      class="text-xs text-gray-400 mt-1">
                    {{ product.category.name }}
                  </div>
                </td>
                
                <!-- Цена -->
                <td v-if="product.discounted_price" class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-white">
                    {{ product.discounted_price }}
                  </div>
                  <div class="text-xs text-gray-400 line-through">
                    {{ product.price }}
                  </div>
                </td>
                <td v-else class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-white">
                    {{ product.price }}
                  </div>
                </td>
                
                <!-- Остаток -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="{
                    'text-green-400': product.stock > 10,
                    'text-yellow-400': product.stock <= 10 && product.stock > 0,
                    'text-red-400': product.stock === 0
                  }">
                    {{ product.stock }} шт.
                  </span>
                </td>
                
                <!-- Рейтинг -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="text-sm mr-2">{{ product.rating }}</span>
                    <div class="flex">
                      <StarIcon v-for="i in 5" :key="i" 
                              class="w-4 h-4"
                              :class="i <= Math.round(product.rating) 
                              ? 'text-yellow-400 fill-current' 
                              : 'text-gray-600'"/>
                    </div>
                  </div>
                </td>
                
                <!-- Скидка -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span v-if="product.discount_percent" 
                      class="px-2 py-1 bg-green-900 text-green-200 rounded-full">
                    -{{ product.discount_percent }}%
                  </span>
                  <span v-else class="text-gray-400">-</span>
                </td>
                
                <!-- Действия -->
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <button @click="openProductModal(product)" 
                          class="text-gray-400 hover:text-gray-200 p-1 rounded-full hover:bg-gray-700 transition-colors">
                    <CogIcon class="w-5 h-5"/>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          
          <!-- Состояние загрузки -->
          <div v-if="loading" class="py-6 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-600 border-t-indigo-500"></div>
          </div>
          
          <!-- Конец списка -->
          <div v-if="!hasMorePages && productsList.length > 0" class="py-4 text-center text-gray-400 text-sm">
            Вы достигли конца списка
          </div>
          
          <!-- Нет товаров -->
          <div v-if="productsList.length === 0 && !loading" 
              class="p-6 text-center text-gray-400">
            Нет товаров для отображения
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно управления товаром -->
    <div v-if="activeProductModal" 
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
        @click="closeProductModal">
      <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md overflow-hidden" 
          @click.stop>
        <div class="px-6 py-4 border-b border-gray-700 flex items-center justify-between">
          <h3 class="text-lg font-medium text-white">Управление товаром</h3>
          <button @click="closeProductModal" class="text-gray-400 hover:text-white">
            <XMarkIcon class="w-5 h-5" />
          </button>
        </div>
        
        <div class="p-6">
          <div v-if="activeProductModal" class="flex items-start space-x-4 mb-6">
            <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-700 flex-shrink-0">
              <img v-if="activeProductModal.image" :src="activeProductModal.image" 
                  class="w-full h-full object-cover" 
                  alt="Изображение товара">
              <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                <PhotoIcon class="w-8 h-8"/>
              </div>
            </div>
            <div>
              <h4 class="text-base font-medium text-white">{{ activeProductModal.name }}</h4>
              <div v-if="activeProductModal.category" class="text-sm text-gray-400 mt-1">
                {{ activeProductModal.category.name }}
              </div>
              <div class="mt-2 text-sm">
                <span class="text-white">ID: #{{ activeProductModal.id }}</span>
              </div>
            </div>
          </div>
          
          <div class="space-y-3">
            <Link :href="route('admin.products', activeProductModal?.id)" 
                  class="block w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-center rounded transition-colors">
              Редактировать товар
            </Link>
            
            <button @click="toggleVisibility(activeProductModal)" 
                    class="block w-full py-2 px-4 bg-gray-700 hover:bg-gray-600 text-white text-center rounded transition-colors">
              {{ activeProductModal?.active ? 'Скрыть товар' : 'Показать товар' }}
            </button>
            
            <button @click="confirmDelete(activeProductModal)" 
                    class="block w-full py-2 px-4 bg-red-800 hover:bg-red-700 text-white text-center rounded transition-colors">
              Удалить товар
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import throttle from 'lodash/throttle';
import AppLayout from '@/Layouts/AppLayout.vue';
import CustomHead from '@/Components/CustomHead.vue';
import PanelHeader from '@/Components/Panel/PanelHeader.vue';
import { 
  PhotoIcon,
  StarIcon,
  CogIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
  products: Object
});

const productsList = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const totalCount = ref(0);
const loading = ref(false);
const hasMorePages = ref(true);
const activeProductModal = ref(null);
const scrollContainer = ref(null);
const isLoadingMore = ref(false);

console.log('Получены данные:', props.products);

const initData = () => {
  if (props.products && props.products.data) {
    productsList.value = [...props.products.data];
    currentPage.value = props.products.current_page || 1;
    lastPage.value = props.products.last_page || 1;
    totalCount.value = props.products.total || 0;
    hasMorePages.value = currentPage.value < lastPage.value;
    
    console.log('Инициализировано товаров:', productsList.value.length);
    console.log('Всего страниц:', lastPage.value);
    console.log('Всего товаров:', totalCount.value);
  } else {
    console.error('Неверная структура данных:', props.products);
  }
};

initData();

watch(() => props.products, () => {
  console.log('Изменились props.products, инициализируем данные заново');
  initData();
}, { deep: true });


const openProductModal = (product) => {
  activeProductModal.value = product;
};

const closeProductModal = () => {
  activeProductModal.value = null;
};

const loadMore = throttle(async () => {
  if (loading.value || isLoadingMore.value || !hasMorePages.value) {
    console.log('Пропускаем загрузку:', { 
      loading: loading.value, 
      isLoadingMore: isLoadingMore.value, 
      hasMorePages: hasMorePages.value 
    });
    return;
  }
  
  console.log('Загружаем следующую страницу:', currentPage.value + 1);
  
  isLoadingMore.value = true;
  loading.value = true;
  
  try {
    const nextPage = currentPage.value + 1;
    
    const response = await axios.get(route('admin.products'), { 
      params: { page: nextPage },
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    });
    
    console.log('Получен ответ:', response.data);
    
    const data = response.data;
    
    if (data && data.data && Array.isArray(data.data)) {
      productsList.value = [...productsList.value, ...data.data];
      currentPage.value = data.current_page;
      lastPage.value = data.last_page;
      totalCount.value = data.total;
      hasMorePages.value = currentPage.value < lastPage.value;
      
      console.log('Обновлено товаров:', productsList.value.length);
      console.log('Текущая страница:', currentPage.value);
      console.log('Всего страниц:', lastPage.value);
    } else {
      console.error('Неверная структура данных в ответе:', data);
    }
    
    await nextTick();
  } catch (e) {
    console.error('Ошибка загрузки:', e);
  } finally {
    loading.value = false;
    isLoadingMore.value = false;
  }
}, 300);

const handleScroll = () => {
  if (!scrollContainer.value) return;
  
  const { scrollTop, scrollHeight, clientHeight } = scrollContainer.value;
  
  const triggerPosition = Math.min(scrollHeight * 0.2, 300);
  const scrollPosition = scrollHeight - (scrollTop + clientHeight);
  
  if (scrollPosition < triggerPosition) {
    console.log('Достигнута позиция для загрузки:', scrollPosition);
    loadMore();
  }
};

onMounted(() => {
  console.log('Компонент смонтирован');
  
  scrollContainer.value = document.querySelector('.overflow-y-auto');
  
  if (scrollContainer.value) {
    console.log('scrollContainer найден');
    
    scrollContainer.value.addEventListener('scroll', handleScroll);
    
    if (scrollContainer.value.scrollHeight <= scrollContainer.value.clientHeight && 
        hasMorePages.value) {
      console.log('Контент меньше вьюпорта, загружаем дополнительные данные');
      console.log('scrollHeight:', scrollContainer.value.scrollHeight);
      console.log('clientHeight:', scrollContainer.value.clientHeight);
      loadMore();
    }
  } else {
    console.error('scrollContainer НЕ найден');
  }
});

onUnmounted(() => {
  if (scrollContainer.value) {
    scrollContainer.value.removeEventListener('scroll', handleScroll);
  }
});

const toggleVisibility = (product) => {
  console.log('Toggle visibility:', product.id);
  closeProductModal();
};

const confirmDelete = (product) => {
  console.log('Confirm delete:', product.id);
  closeProductModal();
};
</script>