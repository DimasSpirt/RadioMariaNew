<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  posts: {
    type: Object,
    required: true
  }
});

const formatShortDate = (dateString) => {
  if (!dateString) return '';
  return new Intl.DateTimeFormat('uk-UA', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  }).format(new Date(dateString));
};
</script>

<template>
  <div class="pt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

      <Link
          v-for="post in posts.data"
          :key="post.id"
          :href="`/${post.link}`"
          class="card-link group flex flex-col bg-white rounded-2xl shadow-sm border border-[var(--border)] overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
      >
        <div class="relative h-56 bg-[var(--light)] overflow-hidden shrink-0">
          <img
              v-if="post.image"
              :src="`${$mediaUrl}/images/content/normal/${post.image}`"
              :alt="post.title"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          >
          <div
              v-if="post.audio"
              class="absolute bottom-4 right-4 bg-[var(--blue)] text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg"
          >
            <svg class="w-6 h-6 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
          </div>
        </div>

        <div class="p-6 flex flex-col flex-grow">
          <h3 class="htitle text-xl mb-3 text-[var(--dark)] group-hover:text-[var(--blue)] transition-colors leading-tight">
            {{ post.title }}
          </h3>

          <div class="intro-text text-[var(--text)] font-sans text-base line-clamp-3 mb-6 flex-grow" v-html="post.introtext"></div>

          <div class="mt-auto flex items-center justify-between pt-4 border-t border-[var(--border)]">
            <div class="text-sm text-[var(--gold)] font-bold font-sans">
              {{ formatShortDate(post.pub_start) }}
            </div>

            <div class="text-[var(--gold)] text-sm font-bold flex items-center gap-2 group-hover:gap-3 transition-all uppercase tracking-wide">
              Читати далі
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
          </div>
        </div>
      </Link>

    </div>

    <div v-if="posts.links && posts.links.length > 3" class="flex flex-wrap justify-center items-center gap-2 mt-12">
      <template v-for="(link, index) in posts.links" :key="index">
        <div
            v-if="link.url === null"
            class="px-4 py-2 text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed font-sans text-sm"
            v-html="link.label"
        ></div>
        <Link
            v-else
            :href="link.url"
            class="page-link px-4 py-2 border rounded-lg transition-colors font-sans text-sm font-medium"
            :class="link.active
                        ? 'bg-[var(--blue)] text-white border-[var(--blue)] shadow-md'
                        : 'bg-white text-[var(--dark)] border-[var(--border)] hover:border-[var(--gold)] hover:text-[var(--gold)]'"
            v-html="link.label"
        ></Link>
      </template>
    </div>
  </div>
</template>

<style scoped>
/* 1. Блокируем глобальное подчеркивание на самой карточке-ссылке и пагинации */
.card-link,
.page-link {
  text-decoration: none !important;
  color: inherit !important;
}

/* 2. Жестко переопределяем цвета заголовков внутри ссылки (защита от глобального .htitle) */
.card-link h3.htitle {
  color: var(--dark) !important;
}
.card-link:hover h3.htitle {
  color: var(--blue) !important;
}

/* 3. Жестко фиксируем цвет текста, чтобы он не унаследовал синий цвет от <a> */
.card-link .intro-text {
  color: var(--text) !important;
}

/* Убираем блочные отступы у возможных абзацев из БД */
:deep(.intro-text p) {
  margin: 0;
  display: inline;
}
</style>