<template>
    <CustomHead title="Админ панель" />
    <AppLayout>
    <PanelHeader />
      <div>
        <main class="p-6">
            <h1 class="text-2xl font-bold text-white mb-6">{{ title }}</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <StatCard title="Total Sales" value="$24,500" icon="CurrencyDollarIcon" trend="up" trend-value="12%"/>
            <StatCard title="New Orders" value="1,234" icon="ShoppingCartIcon" trend="down" trend-value="5%"/>
            <StatCard title="Active Users" value="2,345" icon="UserGroupIcon" trend="up" trend-value="8%"/>
            <StatCard title="Conversion Rate" value="3.2%" icon="ChartPieIcon" trend="stable"/>
            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold text-white">Recent Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr v-for="order in recentOrders" :key="order.id">
                    <td class="px-6 py-4 whitespace-nowrap">#{{ order.id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ order.customer }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <StatusBadge :status="order.status"/>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ order.date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ order.total }}</td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </main>
      </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CustomHead from '@/Components/CustomHead.vue';
import PanelHeader from '@/Components/Panel/PanelHeader.vue';
import StatCard from '@/Components/StatCard.vue';
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { 
  CurrencyDollarIcon,
  ShoppingCartIcon,
  UserGroupIcon,
  ChartPieIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
  title: String,
  recentOrders: Array
})

const page = usePage();
</script>

<style>
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  @apply bg-gray-100 dark:bg-gray-700;
}

::-webkit-scrollbar-thumb {
  @apply bg-gray-300 dark:bg-gray-500 rounded-full;
}

::-webkit-scrollbar-thumb:hover {
  @apply bg-gray-400 dark:bg-gray-400;
}
</style>