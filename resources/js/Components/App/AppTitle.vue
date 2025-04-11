<script setup>
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
  title: String,
});

const page = usePage();
const fullTitle = `${page.props.appName} | ${props.title}`;
</script>

<template>
  <Head :title="fullTitle" />
</template>