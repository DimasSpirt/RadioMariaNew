<script setup>
import { reactive, ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import { playerState } from '@/Store/player';
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

// Функция генерации URL для фильтрации по конкретному значению
const getFilterUrl = (type, id) => {
  const params = new URLSearchParams({
    author: type === 'author' ? id : '',
    program: type === 'program' ? id : '',
    presenter: type === 'presenter' ? id : '',
    date_from: '',
    date_to: '',
    search: '',
  });
  return `/archive?${params.toString()}`;
};

// --- ЛОГИКА АУДИОПЛЕЕРА ---

// Предохранитель от накрутки прослушиваний (храним ID уже отправленных треков в рамках сессии)
const trackedPostIds = ref(new Set());

const trackAudio = (postId) => {
  if (!trackedPostIds.value.has(postId) && postId) {
    axios.post(`/play/track/${postId}`).catch(() => {});
    trackedPostIds.value.add(postId);
  }
};

// Формируем URL аудиофайла для конкретного поста
const getAudioUrl = (post) => {
  if (!post?.audio) return null;
  const mediaUrl = import.meta.env.VITE_MEDIA_URL || '';
  return `${mediaUrl}/audio/content/${post.audio}`;
};

// Проверяем, играет ли именно этот трек сейчас в глобальном плеере
const isTrackPlaying = (post) => {
  const url = getAudioUrl(post);
  return playerState.currentStream === url && playerState.isPlaying;
};

// Проверяем, выбран ли этот трек в плеере (даже если на паузе)
const isTrackCurrent = (post) => {
  const url = getAudioUrl(post);
  return playerState.currentStream === url;
};

// Клик по кнопке Play/Pause в списке
const toggleAudio = (post) => {
  const url = getAudioUrl(post);
  if (!url) return;

  trackAudio(post.id);

  const subtitleStr = post.author?.name || post.program?.name || 'Архівний запис';

  playerState.toggle({
    url: url,
    type: 'podcast',
    title: post.title,
    subtitle: subtitleStr
  });
};

// Конвертируем секунды в формат 0:00
const formatTime = (seconds) => {
  if (!seconds || isNaN(seconds)) return '0:00';
  const m = Math.floor(seconds / 60);
  const s = Math.floor(seconds % 60);
  return `${m}:${s.toString().padStart(2, '0')}`;
};

// Управление звуком (Mute/Unmute)
const isMuted = computed(() => {
  if (playerState.muted !== undefined) {
    return playerState.muted;
  }
  return playerState.volume === 0;
});

const toggleMute = () => {
  if (typeof playerState.toggleMute === 'function') {
    playerState.toggleMute();
  } else if (playerState.muted !== undefined) {
    playerState.muted = !playerState.muted;
  } else {
    // Резервный вариант: переключаем громкость между 0 и 1
    playerState.volume = playerState.volume > 0 ? 0 : 1;
  }
};
</script>

<template>
  <Head title="Архів програм" />

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

            <!-- Интегрированный рабочий плеер -->
            <div v-if="post.audio" class="player-container">
              <!-- Кнопка Play/Pause -->
              <button
                  @click="toggleAudio(post)"
                  class="player-btn"
                  :title="isTrackPlaying(post) ? 'Пауза' : 'Слухати'"
              >
                <svg v-if="!isTrackPlaying(post)" class="player-icon" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M8 5v14l11-7z"/>
                </svg>
                <svg v-else class="player-icon" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                </svg>
              </button>

              <!-- Прогресс-бар и время -->
              <div class="progress-container">
                <span class="time-label">
                  {{ isTrackCurrent(post) ? formatTime(playerState.currentTime) : '0:00' }}
                </span>

                <input
                    type="range"
                    class="progress-slider"
                    min="0"
                    :max="isTrackCurrent(post) && playerState.duration ? playerState.duration : 100"
                    :value="isTrackCurrent(post) ? playerState.currentTime : 0"
                    @input="isTrackCurrent(post) ? playerState.seek($event.target.value) : null"
                    :disabled="!isTrackCurrent(post)"
                >

                <span class="time-label">
                  {{ isTrackCurrent(post) && playerState.duration ? formatTime(playerState.duration) : '0:00' }}
                </span>
              </div>

              <!-- Кнопка Mute/Unmute -->
              <button
                  @click="toggleMute"
                  class="player-btn volume-btn"
                  :title="isMuted ? 'Увімкнути звук' : 'Вимкнути звук'"
              >
                <svg v-if="isMuted" class="player-icon" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M3.63 3.63L2.37 4.89 7.48 10H3v4h4l5 5v-6.79l4.73 4.73c-.69.53-1.46.95-2.3 1.23v2.06c1.38-.33 2.63-.99 3.69-1.87l2.69 2.69 1.26-1.26L3.63 3.63zM12 4L9.91 6.09 12 8.18V4zM16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.21.05-.42.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71z"/>
                </svg>
                <svg v-else class="player-icon" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                </svg>
              </button>

              <!-- Кнопка скачивания (через Laravel-роут для учета скачиваний) -->
              <a
                  :href="`/play/download/${post.id}`"
                  class="player-btn download-btn"
                  title="Завантажити"
              >
                <svg class="player-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
              </a>
            </div>
          </div>

          <div class="post-meta">
            <div class="meta-row">
              <span class="meta-label">Створено:</span>
              <span class="meta-val">{{ formatDate(post.pub_start) }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Програма:</span>
              <span class="meta-val">
                <Link v-if="post.program" :href="getFilterUrl('program', post.program.id)" class="meta-link">
                  {{ post.program.name }}
                </Link>
                <span v-else>—</span>
              </span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Гість:</span>
              <span class="meta-val">
                <Link v-if="post.author" :href="getFilterUrl('author', post.author.id)" class="meta-link">
                  {{ post.author.name }}
                </Link>
                <span v-else>—</span>
              </span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Ведучий:</span>
              <span class="meta-val">
                <Link v-if="post.presenter" :href="getFilterUrl('presenter', post.presenter.id)" class="meta-link">
                  {{ post.presenter.name }}
                </Link>
                <span v-else>—</span>
              </span>
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

/* Стили для нового плеера */
.player-container {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 15px;
  width: 100%;
}

.player-btn {
  background: #337ab7;
  color: white;
  border: none;
  border-radius: 4px;
  width: 36px;
  height: 36px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.2s, transform 0.1s;
  padding: 0;
}

.player-btn:hover {
  background: #286090;
}

.player-btn:active {
  transform: scale(0.95);
}

.player-icon {
  width: 18px;
  height: 18px;
}

.progress-container {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f5f5f5;
  border: 1px solid #ddd;
  border-radius: 20px;
  padding: 0 15px;
  height: 36px;
  box-sizing: border-box;
}

.time-label {
  font-size: 11px;
  font-family: monospace;
  color: #666;
  min-width: 30px;
  text-align: center;
  user-select: none;
}

.progress-slider {
  flex: 1;
  accent-color: #337ab7;
  height: 4px;
  background: #ddd;
  border-radius: 2px;
  cursor: pointer;
  -webkit-appearance: none;
  outline: none;
}

.progress-slider:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

.progress-slider::-webkit-slider-runnable-track {
  width: 100%;
  height: 4px;
  background: transparent;
}

.progress-slider::-webkit-slider-thumb {
  height: 12px;
  width: 12px;
  border-radius: 50%;
  background: #337ab7;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -4px;
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

/* Стили для ссылок в мета-данных */
.meta-link {
  color: #337ab7;
  text-decoration: none;
}
.meta-link:hover {
  text-decoration: underline;
}

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
</style>
