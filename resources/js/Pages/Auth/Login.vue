<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CustomHead from '@/Components/CustomHead.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

// Определяем props
const props = defineProps({
  errors: Object,
});

const form = ref({
  email: '',
  password: '',
  remember: null,
});

const submitForm = () => {
  router.post(route('login.auth'), form.value);
};
</script>

<template>
    <CustomHead title="Вход" />

    <AppLayout>
        <main class="min-h-screen flex items-center justify-center px-4">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h2 class="mt-6 text-3xl font-bold">Войдите в аккаунт</h2>
                    <p class="mt-2 text-sm text-gray-400">
                        Нет аккаунта? 
                        <Link :href="route('register')" class="font-medium text-indigo-400 hover:text-indigo-300">
                            Зарегистрируйтесь
                        </Link>:
                    </p>
                </div>

                <form @submit.prevent="submitForm" class="mt-8 space-y-6 bg-gray-800 p-8 rounded-xl shadow-2xl">
                    <div class="space-y-4">
                        <!-- Кнопка Google -->
                        <a :href="route('login.google')" class="w-full flex items-center justify-center gap-3 bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-md transition-colors">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            <span>Продолжить с Google</span>
                        </a>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-600"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-gray-800 text-gray-400">или через email</span>
                            </div>
                        </div>

                        <span v-if="errors.error" class="text-red-500">{{ errors.error }}</span>

                        <!-- Поле Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" required name="email" v-model="form.email"
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400">
                        </div>

                        <!-- Поле Пароль -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Пароль</label>
                            <input type="password" required name="password" v-model="form.password"
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400">
                        </div>

                        <!-- Вспомогательные ссылки -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" v-model="form.remember"
                                    class="rounded bg-gray-700 border-gray-600 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-gray-300">Запомнить меня</span>
                            </label>
                            <a href="#" class="text-indigo-400 hover:text-indigo-300">Забыли пароль?</a>
                        </div>
                    </div>

                    <!-- Кнопка Входа -->
                    <button type="submit" 
                        class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors font-medium">
                        Войти
                    </button>
                </form>
            </div>
        </main>
    </AppLayout>
</template>