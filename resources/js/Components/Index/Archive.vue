<script setup>
import { ref } from 'vue';
import { useSocials } from '@/Composables/useSocials';
import { Link } from '@inertiajs/vue3';

// 1. Принимаем все данные из нашего IndexController
const props = defineProps({
  featuredPost: Object,
  featuredHighlights: Array,
  programSeries: Object,
  filters: Object,
  popularPrograms: Array,
  totalPosts: Number,
  posts: Object, // Это объект пагинации, сами посты лежат в posts.data
});

const { renderedSocials } = useSocials();

const searchQuery = ref('');
const isFiltersOpen = ref(false);

// Переменные для фильтров
const selectedAuthor = ref('');
const selectedPresenter = ref('');
const dateFrom = ref('');
const dateTo = ref('');

const toggleFilters = () => {
  isFiltersOpen.value = !isFiltersOpen.value;
};

const performSearch = () => {
  console.log('Шукаємо:', searchQuery.value, {
    author: selectedAuthor.value,
    presenter: selectedPresenter.value,
    from: dateFrom.value,
    to: dateTo.value
  });
  // Тут потом сделаем отправку запроса через Inertia.get
};

// 2. Реактивные категории берем из popularPrograms
const activeCategory = ref('Всі');

const setCategory = (catName) => {
  activeCategory.value = catName;
  // Тут можно будет триггерить фильтрацию ленты
};

// 3. Простой хелпер для красивого вывода даты (например, 08.05.2025)
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('uk-UA', {
    day: '2-digit', month: '2-digit', year: 'numeric'
  });
};

// Хелпер для получения картинки (зависит от того, как они хранятся)
const getImageUrl = (path) => {
  if (!path) return '/images/default.jpg';
  // Если у тебя абсолютные ссылки или папка storage:
  return path.startsWith('http') ? path : `/storage/${path}`;
};
</script>

<template>
  <div class="phub">
    <div class="phub-hdr">
      <div>
        <div class="phub-ey">
          <div class="phub-ey-bar"></div>
          <div class="phub-ey-text">Архів і подкасти</div>
        </div>
        <h2 class="phub-title">Слухайте коли <em>зручно</em></h2>
      </div>

      <div class="phub-right" style="position: relative;">
        <div class="hsearch">
          <input
              type="text"
              v-model="searchQuery"
              @keyup.enter="performSearch"
              placeholder="Пошук: назва, ведучий, тема..."
          >
          <button class="hsb" @click="performSearch">
            <svg viewBox="0 0 16 16" stroke-width="1.8">
              <circle cx="7" cy="7" r="4.5"/>
              <line x1="10.5" x2="14" y1="10.5" y2="14"/>
            </svg>
          </button>

          <button
              @click="toggleFilters"
              style="margin-left: 5px; background: none; border: none; cursor: pointer; color: #a1a1aa; padding: 5px;"
              title="Розширений пошук"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
          </button>
        </div>

        <div
            v-if="isFiltersOpen"
            class="legacy-filters-panel"
            style="position: absolute; top: 110%; right: 0; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); z-index: 50; width: 280px;"
        >
          <div style="font-size: 13px; font-weight: 600; color: #333; margin-bottom: 12px;">Розширений пошук</div>

          <select v-model="selectedAuthor" style="width: 100%; margin-bottom: 10px; padding: 6px; border: 1px solid #ddd; border-radius: 4px; color: #333;">
            <option value="">- обрати гостя -</option>
            <option v-for="author in filters.authors" :key="author.id" :value="author.id">
              {{ author.name }}
            </option>
          </select>

          <select v-model="selectedPresenter" style="width: 100%; margin-bottom: 10px; padding: 6px; border: 1px solid #ddd; border-radius: 4px; color: #333;">
            <option value="">- обрати ведучого -</option>
            <option v-for="presenter in filters.presenters" :key="presenter.id" :value="presenter.id">
              {{ presenter.name }}
            </option>
          </select>

          <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <input type="date" v-model="dateFrom" style="width: 50%; padding: 6px; border: 1px solid #ddd; border-radius: 4px; color: #333;">
            <input type="date" v-model="dateTo" style="width: 50%; padding: 6px; border: 1px solid #ddd; border-radius: 4px; color: #333;">
          </div>
          <button @click="performSearch" style="width: 100%; padding: 8px; background: #225a9a; color: white; border: none; border-radius: 4px; cursor: pointer;">Шукати</button>
        </div>

        <!-- Выводим реальное количество постов -->
        <Link class="hall" href="/archive">Весь архів ({{ totalPosts }})</Link>
      </div>
    </div>

    <div class="pfilters">
      <div
          class="pf"
          :class="{ on: activeCategory === 'Всі' }"
          @click="setCategory('Всі')"
      >Всі</div>

      <!-- Динамические категории из popularPrograms -->
      <div
          v-for="prog in popularPrograms"
          :key="prog.id"
          class="pf"
          :class="{ on: activeCategory === prog.name }"
          @click="setCategory(prog.name)"
      >
        {{ prog.name }}
      </div>

      <div class="pf pf-sp" @click="$el.classList.toggle('on')">
        <svg viewBox="0 0 14 14" fill="none">
          <circle cx="7" cy="7" r="6" fill="#1DB954"/>
          <polygon points="5,4 11,7 5,10" fill="white"/>
        </svg>
        Підписатись на Spotify
      </div>
    </div>

    <div class="pod-layout">
      <div class="pod-left">

        <!-- Выбор редакции / Featured Post -->
        <div class="pfeat" v-if="featuredPost">
          <div class="pfeat-img">
            <img :src="getImageUrl(featuredPost.image || featuredPost.detail_image)" :alt="featuredPost.title">
            <div class="pfeat-ov"></div>
            <div class="pfeat-badge">⭐ Рекомендуємо</div>
            <div class="pfeat-play">
              <svg viewBox="0 0 20 20"><polygon points="5,3 17,10 5,17"/></svg>
            </div>
            <div class="pfeat-dur">...</div> <!-- Время пока можно скрыть или доставать из мета-данных аудио -->
          </div>
          <div class="pfeat-body">
            <div class="pfeat-tag">{{ featuredPost.program?.name || 'Радіо Марія' }}</div>
            <div class="pfeat-title">{{ featuredPost.title }}</div>
            <div class="pfeat-host">
              {{ featuredPost.presenter?.name || featuredPost.author?.name || 'Без автора' }}
            </div>
            <div class="pfeat-meta">
              <div class="pfeat-date">{{ formatDate(featuredPost.pub_start) }}</div>
              <div class="ppods">
                <div class="pp">Audio</div> <!-- Пока заглушка для бейджей платформ -->
              </div>
            </div>
          </div>
        </div>

        <!-- Цикл программ -->
        <div class="pseries" v-if="programSeries">
          <div class="pser-hd">
            <div class="pser-label">Цикл програм</div>
            <div class="pser-title">{{ programSeries.program.name }}</div>
            <div class="pser-sub">Останні випуски</div>
          </div>

          <a class="sep" href="#" v-for="(ep, index) in programSeries.episodes" :key="ep.id" :class="{ now: index === 0 }">
            <div class="sep-n" :class="{ cur: index === 0, next: index > 0 }">{{ index === 0 ? '▶' : index + 1 }}</div>
            <div class="sep-i">
              <div class="sep-t">{{ ep.title }}</div>
              <div class="sep-m">{{ formatDate(ep.pub_start) }}</div>
            </div>
            <div class="sep-b cur" v-if="index === 0">Нове</div>
          </a>

          <div class="pser-foot"><a href="#">Всі серії →</a></div>
        </div>
      </div>

      <div class="pod-right">
        <!-- Свежие хайлайты (Карусель) -->
        <div class="prow3">
          <a class="pcard" href="#" v-for="highlight in featuredHighlights" :key="highlight.id">
            <div class="pcard-img">
              <img :src="getImageUrl(highlight.image || highlight.detail_image)" :alt="highlight.title">
              <div class="pcard-ov">
                <div class="pcard-play">
                  <svg viewBox="0 0 10 10"><polygon points="2,1 9,5 2,9"/></svg>
                </div>
              </div>
            </div>
            <div class="pcard-body">
              <div class="pcard-tag">{{ highlight.program?.name }}</div>
              <div class="pcard-title">{{ highlight.title }}</div>
              <div class="pcard-meta">
                <div class="pcard-date">{{ formatDate(highlight.pub_start) }}</div>
              </div>
            </div>
          </a>
        </div>

        <!-- Останні надходження (Главная лента из 12 постов) -->
        <div class="plist">
          <div class="plist-hd">
            <div class="plist-hd-t">Останні надходження</div>
            <div class="plist-hd-c">{{ totalPosts }} записів</div>
          </div>

          <a class="plr" href="#" v-for="post in posts.data" :key="post.id">
            <!-- Заглушка для иконок или миниатюр -->
            <div class="plr-icon" style="background:linear-gradient(135deg,#1565a8,#2080cc)">
              <svg viewBox="0 0 14 14"><polygon points="2,1 12,7 2,13"/></svg>
            </div>
            <div class="plr-info">
              <div class="plr-t">{{ post.title }}</div>
              <div class="plr-s">
                {{ post.program?.name || 'Без рубрики' }} · {{ formatDate(post.pub_start) }}
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="sub-ban">
    <div>
      <div class="sub-title">Підписуйтесь на подкасти</div>
      <div class="sub-desc">Слухайте Радіо Марія де завгодно — в плеєрі, в дорозі, вдома</div>
    </div>

    <div class="sub-btns">
      <a
          v-for="social in renderedSocials"
          :key="'sub-' + social.id"
          class="sbb"
          :href="social.link"
          target="_blank"
          :style="social.name === 'RSS' ? 'border-color:rgba(200,168,75,.4);color:#e8c870' : ''"
      >
        {{ social.name }}
      </a>
    </div>

  </div>
</template>

<style scoped>
.hsearch button:focus { outline: none; }
.legacy-filters-panel select, .legacy-filters-panel input {
  box-sizing: border-box;
}
</style>