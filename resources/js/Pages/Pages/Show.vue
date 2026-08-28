<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
  page: Object,
  allPages: Array,
});
</script>

<template>
  <Head :title="page.title || page.name">
    <meta v-if="page.description" name="description" :content="page.description" />
    <meta v-if="page.keywords" name="keywords" :content="page.keywords" />
  </Head>

    <div class="static-page-container">

      <!-- Навигация по статическим страницам (Табы) -->
      <nav v-if="allPages && allPages.length" class="page-tabs">
        <Link
            v-for="item in allPages"
            :key="item.id"
            :href="route('pages.show', { slug: item.link || item.id })"
            class="tab-btn"
            :class="{ active: item.id === page.id }"
        >
          {{ item.name }}
        </Link>
      </nav>

      <!-- Основной контент -->
      <article class="page-card">
        <h1 class="page-title">{{ page.name }}</h1>

        <div class="page-content html-body" v-html="page.text"></div>
      </article>

    </div>
</template>

<style scoped>
.static-page-container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 0 20px;
}

/* Табы сверху */
.page-tabs {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 24px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  padding-bottom: 16px;
}

.tab-btn {
  padding: 10px 18px;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.05);
  color: #a0aec0;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.tab-btn:hover {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
}

.tab-btn.active {
  background: var(--gold, #e6b74a);
  color: #111;
  box-shadow: 0 4px 12px rgba(230, 183, 74, 0.2);
}

/* Карточка страницы */
.page-card {
  background: #0d1e36;
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 12px;
  padding: 32px;
  color: #e2e8f0;
}

.page-title {
  font-size: 28px;
  font-weight: 700;
  color: #fff;
  margin-bottom: 24px;
  border-bottom: 2px solid var(--gold, #e6b74a);
  padding-bottom: 12px;
}

/* Стилизация входящего HTML из базы */
.html-body :deep(h1),
.html-body :deep(h2),
.html-body :deep(h3) {
  color: #fff;
  margin-top: 24px;
  margin-bottom: 12px;
  font-weight: 600;
}

.html-body :deep(p) {
  line-height: 1.7;
  margin-bottom: 16px;
  font-size: 16px;
  color: #cbd5e0;
}

.html-body :deep(ul),
.html-body :deep(ol) {
  margin-bottom: 16px;
  padding-left: 24px;
}

.html-body :deep(li) {
  margin-bottom: 8px;
  line-height: 1.6;
}

.html-body :deep(a) {
  color: var(--gold, #e6b74a);
  text-decoration: underline;
}

.html-body :deep(a:hover) {
  opacity: 0.85;
}

@media (max-width: 768px) {
  .page-card {
    padding: 20px;
  }

  .page-title {
    font-size: 22px;
  }
}
</style>