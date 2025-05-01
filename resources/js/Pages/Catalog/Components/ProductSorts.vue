<template>
    <div class="w-full md:w-64">
        <select v-model="selectedSort"
            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:ring-2 focus:ring-indigo-500">
           
            <option value="newest">Сначала новинки</option>
            <option value="price_asc">По возрастанию цены</option>
            <option value="price_desc">По убыванию цены</option>
            <option value="popular">По популярности</option>
            <option value="rating">По рейтингу</option>
            
        </select>
    </div>
</template>

<script setup>

</script>
