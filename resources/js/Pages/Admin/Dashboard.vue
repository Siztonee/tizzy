<template>
  <CustomHead title="Админ панель" />
  <AppLayout>
    <PanelHeader />
    <h1>dashboard</h1>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CustomHead from '@/Components/CustomHead.vue';
import PanelHeader from '@/Components/Panel/PanelHeader.vue'

defineProps({
  totalProducts: Number,
  totalOrders: Number,
  totalUsers: Number,
  salesData: Array,
  activityData: Array,
  recentActivities: Array
})
</script>