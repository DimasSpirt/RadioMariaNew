<script setup>
import {Head} from '@inertiajs/vue3';
import Main from '@/Components/Index/Main.vue';
import Posts from '@/Components/Index/Posts.vue';
import Archive from "@/Components/Index/Archive.vue";
import Schedule from "@/Components/Index/Schedule.vue";
import Mission from "@/Components/Index/Mission.vue";

defineProps({
  posts: Object
});

</script>

<template>
  <Head title="Радіо Марія Україна — Новий сайт 2025"/>

    <Main />

    <Archive />

    <Posts :posts="posts" />

    <Schedule />

    <Mission />

</template>