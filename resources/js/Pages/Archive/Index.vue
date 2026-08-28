<script setup>
import { reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
// Импортируем компоненты шапки/меню, которые используются на главной (по аналогии с Index.vue)
import Main from '@/Components/Index/Main.vue';

const props = defineProps({
  posts: Object,
  filters: Object,
  queryParams: Object,
});

// Инициализируем форму текущими параметрами из URL
const form = reactive({
  author: props.queryParams.author || '',
  program: props.queryParams.program || '',
  presenter: props.queryParams.presenter || '',
  date_from: props.queryParams.date_from || '',
  date_to: props.queryParams.date_to || '',
  search: props.queryParams.search || '',
});

const applyFilters = () => {
  router.get('/archive', form, {
    preserveState: true,
    preserveScroll: true,
  });
};

const resetFilters = () => {
  form.author = '';
  form.program = '';
  form.presenter = '';
  form.date_from = '';
  form.date_to = '';
  form.search = '';
  applyFilters();
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toISOString().slice(0, 19).replace('T', ' ');
};

const getImageUrl = (path) => {
  if (!path) return '/images/default.jpg';
  if (path.startsWith('http')) return path;
  const baseUrl = import.meta.env.VITE_MEDIA_URL || '';
  return `${baseUrl.replace(/\/+$/, '')}/images/content/normal/${path}`;
};
</script>

<template>
  <Head title="Архів програм" />

  <!-- Шапка сайта (как на главной) -->
  <Main />

  <div class="archive-container">
    <div class="archive-main">
      <h1 class="page-title">Архів програм</h1>

      <!-- Панель фильтров -->
      <div class="filters-panel">
        <div class="filters-grid">
          <select v-model="form.author" class="form-control">
            <option value="">- обрати гостя -</option>
            <option v-for="author in filters.authors" :key="author.id" :value="author.id">
              {{ author.name }}
            </option>
          </select>

          <select v-model="form.program" class="form-control">
            <option value="">- обрати програму -</option>
            <option v-for="prog in filters.programs" :key="prog.id" :value="prog.id">
              {{ prog.name }}
            </option>
          </select>

          <select v-model="form.presenter" class="form-control">
            <option value="">- обрати ведучого -</option>
            <option v-for="pres in filters.presenters" :key="pres.id" :value="pres.id">
              {{ pres.name }}
            </option>
          </select>

          <input type="date" v-model="form.date_from" class="form-control" placeholder="з дати...">
          <input type="date" v-model="form.date_to" class="form-control" placeholder="по дату...">

          <div class="filter-actions">
            <button @click="resetFilters" class="btn btn-danger" title="Скинути">X</button>
            <button @click="applyFilters" class="btn btn-primary">Шукати</button>
          </div>
        </div>
      </div>

      <!-- Плашка результатов -->
      <div class="results-alert">
        Знайдено {{ posts.total }} записів.
      </div>

      <!-- Список записей -->
      <div class="posts-list">
        <div v-for="post in posts.data" :key="post.id" class="post-item">

          <div class="post-thumbnail">
            <img :src="getImageUrl(post.image)" :alt="post.title">
          </div>

          <div class="post-content">
            <Link :href="`/${post.link}`" class="post-title">{{ post.title }}</Link>

            <div class="player-mockup">
              <button class="player-btn">▶</button>
              <div class="progress-bar"></div>
              <button class="player-btn volume-btn">🔊</button>
              <a :href="post.audio_url" download class="player-btn download-btn">⬇</a>
            </div>
          </div>

          <div class="post-meta">
            <div class="meta-row">
              <span class="meta-label">Створено:</span>
              <span class="meta-val">{{ formatDate(post.pub_start) }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Програма:</span>
              <span class="meta-val text-blue">{{ post.program?.name || '—' }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Гість:</span>
              <span class="meta-val text-blue">{{ post.author?.name || '—' }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Ведучий:</span>
              <span class="meta-val text-blue">{{ post.presenter?.name || '—' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Пагинация Inertia -->
      <div class="pagination" v-if="posts.links.length > 3">
        <template v-for="(link, k) in posts.links" :key="k">
          <div v-if="link.url === null" class="page-link disabled" v-html="link.label"></div>
          <Link v-else :href="link.url" class="page-link" :class="{ 'active': link.active }" v-html="link.label"></Link>
        </template>
      </div>

    </div>

    <!-- Правый сайдбар -->
    <aside class="archive-sidebar">
      <h3 class="sidebar-title">Соціальні мережі</h3>
      <div class="social-icons">
        <a href="#" class="soc-icon tg"></a>
        <a href="#" class="soc-icon yt"></a>
        <a href="#" class="soc-icon fb"></a>
        <a href="#" class="soc-icon rss"></a>
      </div>

      <div class="banner">
        <img src="/images/prayer-banner.jpg" alt="Молитва та привітання">
      </div>
      <div class="banner">
        <img src="/images/donate-banner.jpg" alt="Підтримай Радіо Марія">
      </div>
    </aside>
  </div>
</template>

<style scoped>
.archive-container {
  display: flex;
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 30px 15px;
  font-family: Arial, sans-serif;
}
.archive-main {
  flex: 1;
}
.page-title {
  font-size: 28px;
  color: #333;
  margin-bottom: 20px;
  font-weight: normal;
}
.filters-panel {
  margin-bottom: 20px;
}
.filters-grid {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 15px;
}
.filter-actions {
  display: flex;
  gap: 10px;
}
.form-control {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  color: #555;
}
.btn {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: #fff;
  font-size: 14px;
}
.btn-primary { background: #337ab7; flex: 1; }
.btn-primary:hover { background: #286090; }
.btn-danger { background: #d9534f; padding: 8px 15px; }
.btn-danger:hover { background: #c9302c; }

.results-alert {
  background-color: #d9edf7;
  color: #31708f;
  padding: 15px;
  border-radius: 4px;
  margin-bottom: 30px;
}

.post-item {
  display: flex;
  gap: 20px;
  padding-bottom: 20px;
  margin-bottom: 20px;
  border-bottom: 1px solid #eee;
}
.post-thumbnail img {
  width: 160px;
  height: 90px;
  object-fit: cover;
  border-radius: 4px;
}
.post-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.post-title {
  font-size: 18px;
  color: #337ab7;
  text-decoration: none;
  line-height: 1.3;
}
.post-title:hover { text-decoration: underline; }

.player-mockup {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 15px;
}
.player-btn {
  background: #337ab7;
  color: white;
  border: none;
  border-radius: 4px;
  width: 32px; height: 32px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
}
.progress-bar {
  flex: 1;
  height: 16px;
  background: #f5f5f5;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.post-meta {
  width: 250px;
  font-size: 12px;
  color: #666;
  line-height: 1.6;
}
.meta-row { display: flex; }
.meta-label { width: 70px; color: #999; }
.meta-val { flex: 1; }
.text-blue { color: #337ab7; }

.pagination { display: flex; gap: 5px; margin-top: 30px; }
.page-link {
  padding: 6px 12px;
  border: 1px solid #ddd;
  color: #337ab7;
  text-decoration: none;
  border-radius: 3px;
}
.page-link.active { background: #337ab7; color: #fff; border-color: #337ab7; }
.page-link.disabled { color: #999; cursor: not-allowed; }

.archive-sidebar {
  width: 260px;
}
.sidebar-title {
  font-size: 20px;
  font-weight: normal;
  margin-bottom: 15px;
  color: #333;
}
.social-icons {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}
.soc-icon {
  width: 50px; height: 50px;
  background-color: #337ab7;
  border-radius: 8px;
}
.soc-icon.rss { background-color: #f0ad4e; }
.banner { margin-bottom: 20px; }
.banner img { width: 100%; border-radius: 4px; }
</style>