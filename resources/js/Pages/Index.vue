<script setup>
import {Head} from '@inertiajs/vue3';
import Main from '@/Components/Index/Main.vue';
import Posts from '@/Components/Index/Posts.vue';
import Archive from "@/Components/Index/Archive.vue";
import Schedule from "@/Components/Index/Schedule.vue";
import Mission from "@/Components/Index/Mission.vue";

// Принимаем все данные из IndexController
defineProps({
  posts: Object,
  featuredPost: Object,
  featuredHighlights: Array,
  programSeries: Object,
  filters: Object,
  popularPrograms: Array,
  totalPosts: Number,
});

</script>

<template>
  <Head title="Радіо Марія Україна — Новий сайт 2025"/>

  <Main />

  <!-- Прокидываем переменные внутрь компонента Archive -->
  <Archive
      :featuredPost="featuredPost"
      :featuredHighlights="featuredHighlights"
      :programSeries="programSeries"
      :filters="filters"
      :popularPrograms="popularPrograms"
      :totalPosts="totalPosts"
      :posts="posts"
  />

  <Posts :posts="posts" />

  <Schedule />

  <Mission />

</template>