<script setup>
    import Header from '@/Components/Header.vue';
    import Footer from '@/Components/Footer.vue';
    import Notifications from '@/Components/Notifications.vue'
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-900 text-gray-100">
    <Header />

    <Notifications />

    <div class="flex-grow">
        <slot />
    </div>

    <Footer />
</div>
</template>
