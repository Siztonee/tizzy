<template>
  <!-- Хедер (полная ширина) -->
  <header class="bg-gray-800 shadow-lg sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <!-- Бургер меню для всех устройств -->
          <button @click="isSidebarOpen = !isSidebarOpen" 
                  class="text-gray-400 hover:text-gray-200 p-2 -ml-2">
            <Bars3Icon v-if="!isSidebarOpen" class="w-6 h-6"/>
            <XMarkIcon v-else class="w-6 h-6"/>
          </button>
          
          <a href="/" class="text-2xl font-bold text-indigo-400 ml-2">
            {{ $page.props.appName }}
          </a>
          
          <!-- Десктопная навигация -->
          <div class="hidden lg:flex space-x-8 ml-10">
            <Link :href="route('catalog')" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200 border-transparent py-5">Каталог</Link>
            <a href="#" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200 border-transparent py-5">О нас</a>
            <Link
                  :href="route('admin.dashboard')" 
                  class="text-gray-300 hover:text-indigo-400 transition-colors duration-200 border-transparent py-5">
              Админ панель
            </Link>
          </div>
        </div>
        
        <div class="flex items-center space-x-4">
          <template v-if="$page.props.authUser">
            <span class="text-gray-300">{{ $page.props.authUser.name }} (${{ $page.props.authUser.balance }})</span>
          </template>

          <template v-else>
            <Link :href="route('login')" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200">
              Войти
            </Link>
          </template>

          <a href="#" class="relative p-2 text-gray-400 hover:text-indigo-400 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span class="absolute top-0 right-0 bg-indigo-500 text-xs px-1 rounded-full">3</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Оверлей для мобильных -->
  <div v-if="isSidebarOpen" 
        class="fixed inset-0 bg-black/50 z-40" 
        @click="isSidebarOpen = false">
  </div>

  <!-- Сайдбар -->
  <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 shadow-xl transform transition-transform duration-300 ease-in-out -translate-x-full"
          :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }">
    <h2 class="text-4xl font-bold text-indigo-400 text-center mt-4">
      {{ $page.props.appName }}
    </h2>
    <nav class="p-4 space-y-2 h-full overflow-y-auto">
      <Link :href="route('catalog')" 
            class="block p-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
        <ShoppingBagIcon class="w-5 h-5  inline-block mr-2"/>
        Каталог
      </Link>
      <a href="#" class="block p-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
        <UsersIcon class="w-5 h-5  inline-block mr-2"/>
        О нас
      </a>
      <Link 
            :href="route('admin.dashboard')" 
            class="block p-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
        <ChartBarIcon class="w-5 h-5  inline-block mr-2"/>
        Админ панель
      </Link>
    </nav>
  </aside>
</template>

<script setup>
import { ref, watch } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import { Bars3Icon, XMarkIcon, ShoppingBagIcon, UsersIcon, ChartBarIcon } from '@heroicons/vue/24/outline'

const page = usePage()
const isSidebarOpen = ref(false)

watch(
  () => page.url,
  () => {
    isSidebarOpen.value = false
  }
)
</script>

<style>
/* Плавные переходы для интерактивных элементов */
.transition-colors {
  transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
}

/* Убираем скроллбар в сайдбаре */
nav::-webkit-scrollbar {
  width: 0;
  background: transparent;
}

nav {
  scrollbar-width: none;
}
</style>