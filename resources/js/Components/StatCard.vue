<template>
  <div class="bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-400 mb-1">{{ title }}</p>
        <p class="text-2xl font-bold text-white">{{ value }}</p>
      </div>
      <div class="p-3 rounded-full bg-indigo-900 text-indigo-300">
        <component :is="icon" class="w-6 h-6"/>
      </div>
    </div>
    <div v-if="trend" class="mt-4 flex items-center text-sm" :class="trendColor">
      <ArrowTrendingUpIcon v-if="trend === 'up'" class="w-4 h-4 mr-1"/>
      <ArrowTrendingDownIcon v-else-if="trend === 'down'" class="w-4 h-4 mr-1"/>
      <span>{{ trendValue }}</span>
    </div>
  </div>
</template>

<script setup>
import { ArrowTrendingUpIcon, ArrowTrendingDownIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  title: String,
  value: String,
  icon: Object,
  trend: String,
  trendValue: String
})

const trendColor = computed(() => {
  return {
    'up': 'text-green-400',
    'down': 'text-red-400',
    'stable': 'text-gray-400'
  }[props.trend]
})
</script>
