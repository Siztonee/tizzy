<template>
  <AppTitle title="Админ панель" />
  <AppLayout>
    <PanelHeader />
    <h1>dashboard</h1>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppTitle from '@/Components/App/AppTitle.vue';
import PanelHeader from '@/Pages/Admin/components/PanelHeader.vue'

defineProps({
  totalProducts: Number,
  totalOrders: Number,
  totalUsers: Number,
  salesData: Array,
  activityData: Array,
  recentActivities: Array
})
</script>