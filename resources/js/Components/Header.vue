<script setup>
import {Link} from '@inertiajs/vue3';
import {ref, onMounted} from 'vue';
import { playerState } from '@/Store/player'; // Подключаем глобальный стейт

const isDropOpen = ref(false);

const audioRef = ref(null);

// Как только шапка загрузится, отдаем ссылку на тег <audio> в глобальный стейт
onMounted(() => {
  playerState.audioElement = audioRef.value;
});
</script>

<template>
  <div class="player-nav">
    <audio ref="audioRef" :src="playerState.currentStream" preload="none"></audio>

    <div class="player-bar">
      <div class="live-pill">
        <div class="ldot"></div>
        <span class="ltext">Live</span>
      </div>
      <div class="pinfo">
        <div class="pnow">Заклик до Бердичівської Богородиці — о. Олексій Самсонов</div>
        <div class="pnext">Наступна: <span>Розарій о 21:00</span></div>
      </div>
      <div class="skip">−15</div>

      <button class="play-btn" @click="playerState.toggle()">
        <svg v-if="!playerState.isPlaying" viewBox="0 0 12 12">
          <polygon points="2,1 11,6 2,11"/>
        </svg>
        <svg v-else viewBox="0 0 12 12">
          <rect x="2" y="2" width="3" height="8"/>
          <rect x="7" y="2" width="3" height="8"/>
        </svg>
      </button>

      <div class="skip">+15</div>
      <div class="strsw">
        <div class="sch on">📻 FM-ефір</div>
        <div class="sch">📿 Молитва</div>
      </div>
      <div class="ptog" @click="isDropOpen = !isDropOpen">☰ Розклад</div>
      <div class="embl">⧉ Вікно</div>
    </div>

    <div class="pdrop" :class="{ open: isDropOpen }" id="pdrop">
      <div class="prow past">
        <div class="prow-t">19:30</div>
        <div class="prow-n">Катехиза — о. Тарас</div>
      </div>
      <div class="prow now">
        <div class="prow-t">20:00</div>
        <div class="prow-n">▶ Заклик до Бердичівської Богородиці</div>
      </div>
      <div class="prow">
        <div class="prow-t">21:00</div>
        <div class="prow-n">Розарій — Болісні таємниці</div>
      </div>
      <div class="prow">
        <div class="prow-t">22:00</div>
        <div class="prow-n">Нічна молитва та Комплета</div>
      </div>
    </div>

    <div class="nav-bar">
      <a class="nl on" href="#">Подкасти і архів</a>
      <a class="nl" href="#">Програма</a>
      <a class="nl" href="#">Молитва</a>
      <a class="nl" href="#">Місія</a>
      <a class="nl" href="#">Для тих, хто шукає</a>
      <Link class="nl nl-listen" href="/play">
        <svg viewBox="0 0 10 10">
          <polygon points="2,1 9,5 2,9"/>
        </svg>
        Слухати зараз
      </Link>
      <a class="nl nl-donate" href="#">
        <svg viewBox="0 0 14 14" stroke-width="2">
          <line x1="7" y1="1" x2="7" y2="13"/>
          <path d="M4 4c0-1.7 6-1.7 6 0s-6 2-6 4 6 1.7 6 0"/>
        </svg>
        Підтримати</a>
    </div>
  </div>
</template>