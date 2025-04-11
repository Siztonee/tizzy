<script setup>
    import Header from '@/Layouts/AppHeader.vue';
    import Footer from '@/Layouts/AppFooter.vue';
    import Notifications from '@/Components/App/Notifications.vue'
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
