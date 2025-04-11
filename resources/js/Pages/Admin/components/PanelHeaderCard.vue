<template>
  <Link :href="href" class="group">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition-all">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ title }}</p>
          <p v-if="count" class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ count.toLocaleString() }}
          </p>
          <p v-if="info" class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ info }}
          </p>
        </div>
        <div :class="color" class="p-4 rounded-lg">
          <component 
            :is="heroicons[icon]" 
            class="w-6 h-6"
          />
        </div>
      </div>
      <div class="mt-4">
        <span class="text-indigo-600 dark:text-indigo-400 group-hover:underline">
          Подробнее →
        </span>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import * as heroicons from '@heroicons/vue/24/outline'

defineProps({
  title: String,
  count: Number,
  info: String,
  icon: String,
  color: String,
  href: String
})
</script>