<template>
  <div class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <TransitionGroup
      name="notification"
      tag="div"
      class="notifications-list"
    >
      <div
        v-for="notification in notifications"
        :key="notification.id"
        :class="notificationClasses(notification.type)"
        class="relative p-4 pr-10 rounded-lg shadow-lg transition-all duration-300 transform cursor-pointer"
        role="alert"
      >
        <!-- Иконка типа -->
        <div class="absolute left-4 top-4">
          <component :is="typeIcon(notification.type)" class="w-6 h-6" />
        </div>

        <!-- Текст -->
        <div class="ml-10">
          <p class="text-sm font-medium">
            {{ notification.message }}
          </p>
        </div>

        <!-- Крестик закрытия -->
        <button
          @click.stop="removeNotification(notification.id)"
          class="absolute top-3 right-3 p-1 hover:opacity-70 transition-opacity"
        >
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const notifications = ref([])
let id = 0

const typeIcon = (type) => {
  const icons = {
    success: SuccessIcon,
    error: ErrorIcon,
    info: InfoIcon,
  }
  return icons[type] || InfoIcon
}

const notificationClasses = (type) => {
  return {
    'bg-green-50 text-green-800': type === 'success',
    'bg-red-50 text-red-800': type === 'error',
    'bg-blue-50 text-blue-800': type === 'info',
  }
}

const addNotification = (data) => {
  const notification = {
    id: id++,
    ...data
  }
  
  notifications.value.push(notification)
  
  setTimeout(() => {
    removeNotification(notification.id)
  }, 5000)
}

const removeNotification = (notificationId) => {
  notifications.value = notifications.value.filter(
    n => n.id !== notificationId
  )
}

// Иконки SVG
const SuccessIcon = {
  template: `
    <svg class="text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
  `
}

const ErrorIcon = {
  template: `
    <svg class="text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
  `
}

const InfoIcon = {
  template: `
    <svg class="text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
  `
}

const handleNotifications = () => {
  const notification = usePage().props.notification
  if (notification) {
    addNotification(notification)
    Inertia.reload({ only: ['notification'], preserveState: true })
  }
}

onMounted(handleNotifications)
watch(() => usePage().props.notification, handleNotifications)

</script>

<style>
.notification-enter-active,
.notification-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.notification-move {
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
