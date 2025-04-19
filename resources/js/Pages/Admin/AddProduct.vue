<template>
  <AppTitle title="Добавить товар" />
  <AppLayout> 
    <PanelHeader />
    <div class="max-w-6xl mx-auto px-4 py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-indigo-400">Добавление товара</h1>
        <div class="flex space-x-4">
          <button class="btn-primary">
            Сохранить
          </button>
        </div>
      </div>

      <!-- Основной контент -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Блок с изображением -->
        <div class="lg:col-span-1">
          <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
            <label class="cursor-pointer group">
              <input type="file" class="hidden" @change="previewImage">
              <div class="aspect-square w-full rounded-lg border-2 border-dashed border-gray-600 flex items-center justify-center group-hover:border-indigo-400 transition-colors">
                <template v-if="!imagePreview">
                  <div class="text-center">
                    <PhotoIcon class="w-12 h-12 text-gray-500 mx-auto mb-3"/>
                    <p class="text-gray-400 text-sm">Загрузите изображение</p>
                    <p class="text-gray-500 text-xs mt-1">Рекомендуемый размер 800x800px</p>
                  </div>
                </template>
                <img v-else :src="imagePreview" 
                    class="w-full h-full object-cover rounded-lg">
              </div>
            </label>
          </div>
        </div>

        <!-- Форма -->
        <div class="lg:col-span-2">
          <form class="space-y-6">
            <!-- Название -->
            <div>
              <label class="block mb-2 text-sm font-medium flex items-center">
                <TagIcon class="w-5 h-5 mr-2 text-gray-400"/>
                Название товара
              </label>
              <input type="text" 
                    class="w-full input-field"
                    placeholder="Кроссовки спортивные...">
            </div>

            <!-- Описание -->
            <div>
              <label class="block mb-2 text-sm font-medium flex items-center">
                <DocumentTextIcon class="w-5 h-5 mr-2 text-gray-400"/>
                Описание
              </label>
              <textarea 
                rows="4"
                class="w-full input-field"
                placeholder="Подробное описание товара..."></textarea>
            </div>

            <!-- Цена и Скидка -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block mb-2 text-sm font-medium">Цена</label>
                <div class="relative">
                  <input type="number" 
                        class="input-field pl-10"
                        placeholder="0.00">
                </div>
              </div>
              
              <div>
                <label class="block mb-2 text-sm font-medium">Скидка</label>
                <div class="relative">
                  <input type="number" 
                        min="0" 
                        max="100"
                        class="input-field pr-10"
                        placeholder="0">
                </div>
              </div>
            </div>

            <!-- Категория и Бренд -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block mb-2 text-sm font-medium flex items-center">
                  <FolderIcon class="w-5 h-5 mr-2 text-gray-400"/>
                  Категория
                </label>
                <select class="w-full input-field">
                  <option value="">Выберите категорию</option>
                  <option v-for="category in categories" 
                          :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium flex items-center">
                  <TruckIcon class="w-5 h-5 mr-2 text-gray-400"/>
                  Бренд
                </label>
                <select class="w-full input-field">
                  <option value="">Выберите бренд</option>
                  <option v-for="brand in brands" 
                          :value="brand.id">
                    {{ brand.name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Остаток -->
            <div>
              <label class="block mb-2 text-sm font-medium">Остаток на складе</label>
              <input type="number" 
                    class="input-field"
                    placeholder="Введите количество">
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import AppTitle from "@/Components/App/AppTitle.vue";
import PanelHeader from '@/Pages/Admin/components/PanelHeader.vue';
import { ref } from 'vue'
import { 
  PhotoIcon,
  TagIcon,
  DocumentTextIcon,
  FolderIcon,
  TruckIcon
} from '@heroicons/vue/24/outline'

const imagePreview = ref(null)

const previewImage = (event) => {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}
</script>

<style>
.input-field {
  @apply w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg 
         text-gray-100 placeholder-gray-500 
         focus:ring-2 focus:ring-indigo-500 focus:border-transparent 
         transition-all duration-200;
}

.btn-primary {
  @apply px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg 
         font-medium transition-colors;
}
</style>