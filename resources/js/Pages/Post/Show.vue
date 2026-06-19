<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue'; // <-- ВОТ ОНА, ПОТЕРЯШКА!
import axios from 'axios';

const props = defineProps({
  post: Object,
  similar: Array
});

// --- ЛОГИКА ПЛЕЕРА ПОСТА ---
const localAudioRef = ref(null);
const hasTracked = ref(false); // Предохранитель от накрутки

// Фоновый трекинг прослушивания
const trackAudio = () => {
  if (!hasTracked.value && props.post?.id) {
    axios.post(`/play/track/${props.post.id}`).catch(() => {});
    hasTracked.value = true; // Считаем только 1 раз за загрузку страницы
  }
};

// Чтобы золотая кнопка тоже умела включать звук
const toggleLocalAudio = () => {
  if (localAudioRef.value) {
    if (localAudioRef.value.paused) {
      localAudioRef.value.play(); // При вызове play() сработает событие @play
    } else {
      localAudioRef.value.pause();
    }
  }
};
// ---------------------------

// Красиво форматируем дату из базы
const formattedDate = computed(() => {
  if (!props.post?.pub_start) return '';
  const date = new Date(props.post.pub_start);
  return new Intl.DateTimeFormat('uk-UA', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  }).format(date);
});

// Дата для блока "Похожие"
const formatShortDate = (dateString) => {
  if (!dateString) return '';
  return new Intl.DateTimeFormat('uk-UA', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(new Date(dateString));
};
</script>

<template>
  <!-- Основной фон голубой (blue), базовый текст белый -->
  <div class="w-full bg-[var(--blue)] text-white pt-10 pb-20 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 flex flex-col lg:flex-row gap-12">

      <!-- ЛЕВАЯ КОЛОНКА (Статья) -->
      <div class="lg:w-2/3">

        <!-- Крошки (жестко задаем цвет ссылкам и разделителям) -->
        <div class="text-base mb-6 flex flex-wrap items-center gap-2 font-sans">
          <Link href="/" class="text-white/70 hover:text-[var(--gold)] transition">Головна</Link>
          <span v-if="post.program" class="text-white/40">/</span>
          <Link v-if="post.program" :href="`/archive?program=${post.audio_program}`" class="text-white/70 hover:text-[var(--gold)] transition">
            {{ post.program.name }}
          </Link>
          <span class="text-white/40">/</span>
          <span class="text-white/50">{{ post.title }}</span>
        </div>

        <!-- Заголовок -->
        <h1 class="htitle text-3xl md:text-4xl mb-8 leading-tight text-white">{{ post.title }}</h1>

        <!-- Мета-данные СТОЛБИКОМ -->
        <div class="flex flex-col gap-3 font-sans text-lg mb-10 text-white/90">
          <div class="flex items-center gap-3">
            <span class="text-white/60 w-24 shrink-0">Створено:</span>
            <strong>{{ formattedDate }}</strong>
          </div>
          <div v-if="post.program" class="flex items-center gap-3">
            <span class="text-white/60 w-24 shrink-0">Програма:</span>
            <Link :href="`/archive?program=${post.audio_program}`" class="text-[var(--gold)] hover:underline"><strong>{{ post.program.name }}</strong></Link>
          </div>
          <div v-if="post.author" class="flex items-center gap-3">
            <span class="text-white/60 w-24 shrink-0">Гість:</span>
            <Link :href="`/archive?author=${post.audio_author}`" class="text-[var(--gold)] hover:underline"><strong>{{ post.author.name }}</strong></Link>
          </div>
          <div v-if="post.presenter" class="flex items-center gap-3">
            <span class="text-white/60 w-24 shrink-0">Ведучий:</span>
            <Link :href="`/archive?presenter=${post.audio_presenter}`" class="text-[var(--gold)] hover:underline"><strong>{{ post.presenter.name }}</strong></Link>
          </div>
        </div>

        <!-- Картинка ПЕРЕД текстом -->
        <img v-if="post.image" :src="`${$mediaUrl}/images/content/normal/${post.image}`" :alt="post.title" class="w-full h-auto rounded-3xl mb-10 object-cover shadow-sm border border-white/20">

        <!-- Текст статьи ПЕРЕД плеером -->
        <div class="prose prose-lg max-w-none font-sans text-white/90 leading-relaxed mb-10 custom-prose" v-html="post.fulltext || post.introtext"></div>

        <div v-if="post.audio" class="bg-white/10 text-white p-6 rounded-2xl flex flex-col md:flex-row items-center gap-6 shadow-md border border-white/10 mb-16">

          <button
              @click="toggleLocalAudio"
              class="w-16 h-16 shrink-0 bg-[var(--gold)] text-[var(--dark)] rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-md"
          >
            <svg class="w-8 h-8 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
          </button>

          <div class="flex-grow w-full">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
              <div class="font-bold text-lg font-sans">Слухати аудіозапис</div>

              <a
                  :href="`/play/download/${post.id}`"
                  class="text-[var(--gold)] text-sm font-bold flex items-center gap-1.5 hover:underline transition-all"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Завантажити
              </a>
            </div>

            <audio
                ref="localAudioRef"
                class="w-full h-10 custom-audio"
                :src="`${$mediaUrl}/audio/content/${post.audio}`"
                controls
                preload="none"
                @play="trackAudio"
            ></audio>
          </div>

        </div>

      </div>

      <!-- ПРАВАЯ КОЛОНКА (Similar СТОЛБИКОМ) -->
      <div class="lg:w-1/3">
        <div class="sticky top-8">
          <div class="mb-4 inline-flex items-center gap-2">
            <div class="w-8 h-1 bg-[var(--gold)]"></div>
            <div class="font-bold tracking-widest text-sm uppercase text-white/70">Архів</div>
          </div>

          <h2 class="htitle text-2xl mb-6 text-white">Схожі матеріали</h2>

          <div class="flex flex-col gap-6">
            <Link v-for="item in similar" :key="item.id" :href="`/${item.link}`" class="group flex flex-col bg-white/5 rounded-2xl border border-white/10 overflow-hidden hover:bg-white/10 transition">

              <div v-if="item.image" class="h-40 bg-white/5 overflow-hidden relative">
                <img :src="`${$mediaUrl}/images/content/normal/${item.image}`" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div v-if="item.audio" class="absolute bottom-3 right-3 bg-[var(--gold)] text-[var(--dark)] w-8 h-8 rounded-full flex items-center justify-center shadow-lg">
                  <svg class="w-4 h-4 ml-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                </div>
              </div>

              <div class="p-5 flex flex-col flex-grow">
                <div class="text-xs text-white/50 mb-2">{{ formatShortDate(item.pub_start) }}</div>

                <h3 class="htitle text-base md:text-lg mb-2 group-hover:text-[var(--gold)] transition leading-tight text-white">{{ item.title }}</h3>

                <div class="mt-auto text-[var(--gold)] text-xs font-medium flex items-center gap-2 group-hover:gap-3 transition-all pt-3 border-t border-white/10">
                  Читати далі <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
              </div>
            </Link>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>
:deep(.custom-prose p) { margin-bottom: 1.5em; }
:deep(.custom-prose a) { color: var(--gold); text-decoration: underline; font-weight: 500; }
:deep(.custom-prose h1),
:deep(.custom-prose h2),
:deep(.custom-prose h3),
:deep(.custom-prose h4) { color: white; font-family: 'Cormorant Garamond', serif; margin-top: 1.5em; margin-bottom: 0.5em; }
:deep(.custom-prose strong) { color: white; font-weight: 600; }
:deep(.custom-prose img) { border-radius: 12px; margin: 2rem auto; border: 1px solid rgba(255, 255, 255, 0.2); }
:deep(.custom-prose ul), :deep(.custom-prose ol) { color: rgba(255, 255, 255, 0.9); }

/* Одной строчкой переводим нативный плеер в темную тему */
.custom-audio {
  color-scheme: dark;
}
</style>