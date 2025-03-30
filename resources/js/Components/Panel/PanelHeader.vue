<template>
    <div class="bg-gray-900">
      <!-- Основной контент -->
      <div class="p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Админ панель</h1>
        
        <!-- Карточки быстрого доступа -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-2">
          <PanelHeaderCard 
            title="Товары" 
            :count="totalProducts" 
            icon="ArchiveBoxIcon"
            color="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300"
            :href="route('admin.products')"
          />

          <PanelHeaderCard 
            title="Заказы" 
            :count="totalOrders" 
            icon="ClipboardDocumentListIcon"
            color="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300"
            :href="route('admin.orders')"
          />

          <PanelHeaderCard 
            title="Пользователи" 
            :count="totalUsers" 
            icon="UserGroupIcon"
            color="bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300"
            :href="route('admin.dashboard')"
          />

          <PanelHeaderCard 
            title="Статистика" 
            info="30 дней"
            icon="ChartBarIcon"
            color="bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300"
            :href="route('admin.dashboard')"
          />
        </div>
      </div>
    </div>
</template>

<script setup>
import PanelHeaderCard from '@/Components/Panel/PanelHeaderCard.vue'

defineProps({
  totalProducts: Number,
  totalOrders: Number,
  totalUsers: Number,
  salesData: Array,
  activityData: Array,
  recentActivities: Array
})
</script>