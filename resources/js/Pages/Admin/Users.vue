<template>
  <AppTitle title="Управление пользователями" />
  <AppLayout>
    <PanelHeader />
    <div class="h-full flex flex-col bg-gray-900 rounded-xl shadow mb-12 p-6 lg:p-8">
      <!-- Заголовок и кнопки -->
      <div class="mb-8 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Управление пользователями</h2>
      </div>

      <!-- Счетчик пользователей -->
      <div class="mb-4 text-sm text-gray-400">
        Отображается {{ usersList.length }} из {{ totalCount }} пользователей
      </div>

      <!-- Контейнер таблицы -->
      <div class="flex-1 overflow-hidden relative">
        <div class="h-[calc(150vh-270px)] overflow-y-auto rounded-md" ref="scrollContainer">
          <!-- Таблица -->
          <table class="w-full relative">
            <thead class="sticky top-0 bg-gray-800 z-10">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Имя</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Роль</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Баланс</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Дата регистрации</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Статус</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"></th>
              </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-700">
              <tr v-for="user in usersList" :key="user.id" 
                  class="hover:bg-gray-800 transition-colors">
                <!-- ID -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-300">
                  #{{ user.id }}
                </td>
                
                <!-- Имя -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                  {{ user.name }}
                </td>
                
                <!-- Email -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                  {{ user.email }}
                </td>
                
                <!-- Роль -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                  {{ user.role }}
                </td>
                
                <!-- Баланс -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                  {{ user.balance }} ₽
                </td>
                
                <!-- Дата регистрации -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                  {{ new Date(user.created_at).toLocaleDateString() }}
                </td>
                
                <!-- Статус -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="{
                    'text-green-400': user.status === 'online',
                    'text-gray-400': user.status === 'offline',
                    'text-red-400': user.status === 'banned'
                  }" class="text-sm capitalize">
                    {{ user.status }}
                  </span>
                </td>
                
                <!-- Действия -->
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <button @click="openUserModal(user)" 
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
          <div v-if="!hasMorePages && usersList.length > 0" class="py-4 text-center text-gray-400 text-sm">
            Вы достигли конца списка
          </div>
          
          <!-- Нет пользователей -->
          <div v-if="usersList.length === 0 && !loading" 
              class="p-6 text-center text-gray-400">
            Нет пользователей для отображения
          </div>
        </div>
      </div>
    </div>

    <!-- Модальное окно управления пользователем -->
    <div v-if="activeUserModal" 
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
        @click="closeUserModal">
      <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md overflow-hidden" 
          @click.stop>
        <div class="px-6 py-4 border-b border-gray-700 flex items-center justify-between">
          <h3 class="text-lg font-medium text-white">Управление пользователем</h3>
          <button @click="closeUserModal" class="text-gray-400 hover:text-white">
            <XMarkIcon class="w-5 h-5" />
          </button>
        </div>
        
        <div class="p-6">
          <div class="space-y-4">
            <!-- Изменение роли -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Роль</label>
              <select v-model="activeUserModal.role" 
                      class="w-full bg-gray-700 text-white rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="user">Пользователь</option>
                <option value="admin">Администратор</option>
                <option value="moderator">Модератор</option>
              </select>
            </div>

            <!-- Изменение баланса -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Баланс</label>
              <input type="number" 
                     v-model="activeUserModal.balance" 
                     class="w-full bg-gray-700 text-white rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <!-- Блокировка/Разблокировка -->
            <button @click="toggleBlock" 
                    class="w-full py-2 px-4 bg-red-800 hover:bg-red-700 text-white rounded transition-colors">
              {{ activeUserModal.status === 'banned' ? 'Разблокировать' : 'Заблокировать' }}
            </button>

            <!-- Удаление -->
            <button @click="confirmDelete" 
                    class="w-full py-2 px-4 bg-gray-700 hover:bg-gray-600 text-white rounded transition-colors">
              Удалить пользователя
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import throttle from 'lodash/throttle';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppTitle from '@/Components/App/AppTitle.vue';
import PanelHeader from '@/Pages/Admin/components/PanelHeader.vue';
import { 
  CogIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
  users: Object
});

const usersList = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const totalCount = ref(0);
const loading = ref(false);
const hasMorePages = ref(true);
const activeUserModal = ref(null);
const scrollContainer = ref(null);
const isLoadingMore = ref(false);

const initData = () => {
  if (props.users && props.users.data) {
    usersList.value = [...props.users.data];
    currentPage.value = props.users.current_page || 1;
    lastPage.value = props.users.last_page || 1;
    totalCount.value = props.users.total || 0;
    hasMorePages.value = currentPage.value < lastPage.value;
  }
};

initData();

watch(() => props.users, () => {
  initData();
}, { deep: true });

const openUserModal = (user) => {
  activeUserModal.value = { ...user };
};

const closeUserModal = () => {
  activeUserModal.value = null;
};

const loadMore = throttle(async () => {
  if (loading.value || isLoadingMore.value || !hasMorePages.value) return;
  
  isLoadingMore.value = true;
  loading.value = true;
  
  try {
    const nextPage = currentPage.value + 1;
    const response = await axios.get(route('admin.users'), { 
      params: { page: nextPage },
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    
    const data = response.data;
    
    if (data?.data) {
      usersList.value = [...usersList.value, ...data.data];
      currentPage.value = data.current_page;
      lastPage.value = data.last_page;
      hasMorePages.value = currentPage.value < lastPage.value;
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
  
  if (scrollPosition < triggerPosition) loadMore();
};

const toggleBlock = () => {
  console.log('Toggle block:', activeUserModal.value.id);
  closeUserModal();
};

const confirmDelete = () => {
  console.log('Confirm delete:', activeUserModal.value.id);
  closeUserModal();
};

onMounted(() => {
  scrollContainer.value = document.querySelector('.overflow-y-auto');
  if (scrollContainer.value) {
    scrollContainer.value.addEventListener('scroll', handleScroll);
    if (scrollContainer.value.scrollHeight <= scrollContainer.value.clientHeight && hasMorePages.value) {
      loadMore();
    }
  }
});

onUnmounted(() => {
  if (scrollContainer.value) {
    scrollContainer.value.removeEventListener('scroll', handleScroll);
  }
});
</script>