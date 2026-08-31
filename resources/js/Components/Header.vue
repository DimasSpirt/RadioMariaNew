<script setup>
import {Link} from '@inertiajs/vue3';
import {ref, onMounted, onUnmounted} from 'vue';
import { playerState } from '@/Store/player';
import { useIntensionModal } from '@/Composables/useIntensionModal';

const isDropOpen = ref(false);
const audioRef = ref(null);

const { openModal } = useIntensionModal();

// Переменные для подсветки пунктов меню
const isMissionActive = ref(false);
const isProgramActive = ref(false); // Добавили для "Програма"

// Функция открытия окна плеера
const openPopUpPlayer = () => {
  const url = '/play';
  const features = 'width=380,height=550,resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,status=no';

  window.open(url, 'RadioMariaPopup', features);

  // Ставим текущий плеер на паузу, чтобы звук не дублировался
  if (playerState.isPlaying) {
    playerState.isPlaying = false;
  }
};

// Функция-шпион, которая проверяет позицию блоков
const checkScroll = () => {
  // Проверка для блока "Місія"
  const missionEl = document.getElementById('mission');
  if (!missionEl) {
    isMissionActive.value = false;
  } else {
    const rect = missionEl.getBoundingClientRect();
    isMissionActive.value = rect.top <= window.innerHeight / 2 && rect.bottom >= 100;
  }

  // Проверка для блока "Програма"
  const programEl = document.getElementById('program');
  if (!programEl) {
    isProgramActive.value = false;
  } else {
    const rectProg = programEl.getBoundingClientRect();
    isProgramActive.value = rectProg.top <= window.innerHeight / 2 && rectProg.bottom >= 100;
  }
};

// Как только шапка загрузится, отдаем ссылку на тег <audio> в глобальный стейт,
// загружаем расписание, запускаем таймер и вешаем слушатель скролла
onMounted(() => {
  playerState.audioElement = audioRef.value;
  playerState.fetchSchedule();
  playerState.initLiveTimer();

  window.addEventListener('scroll', checkScroll, { passive: true });
  checkScroll();
});

// Убираем слушатель при уничтожении компонента
onUnmounted(() => {
  window.removeEventListener('scroll', checkScroll);
});
</script>

<template>
  <div class="player-nav">
    <audio
        ref="audioRef"
        :src="playerState.currentStream"
        :muted="playerState.muted"
        preload="none"
        @timeupdate="playerState.currentTime = $event.target.currentTime"
        @loadedmetadata="playerState.duration = $event.target.duration"
        @ended="playerState.isPlaying = false"
    ></audio>

    <div class="player-bar">
      <div class="live-pill" :style="playerState.trackType === 'podcast' ? 'background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);' : ''">
        <div class="ldot" v-if="playerState.trackType === 'live'"></div>
        <span class="ltext">{{ playerState.trackType === 'live' ? 'Live' : 'Архів' }}</span>
      </div>

      <div class="pinfo">
        <div class="pnow">{{ playerState.trackTitle }}</div>
        <div class="pnext" v-html="playerState.subtitle"></div>
      </div>

      <div
          class="skip"
          style="cursor: pointer;"
          :style="{ visibility: playerState.trackType === 'podcast' ? 'visible' : 'hidden' }"
          @click="playerState.skip(-15)"
      >−15</div>

      <button class="play-btn" @click="playerState.toggle()">
        <svg v-if="!playerState.isPlaying" viewBox="0 0 12 12">
          <polygon points="2,1 11,6 2,11"/>
        </svg>
        <svg v-else viewBox="0 0 12 12">
          <rect x="2" y="2" width="3" height="8"/>
          <rect x="7" y="2" width="3" height="8"/>
        </svg>
      </button>

      <div
          class="skip"
          style="cursor: pointer;"
          :style="{ visibility: playerState.trackType === 'podcast' ? 'visible' : 'hidden' }"
          @click="playerState.skip(15)"
      >+15</div>

      <div class="strsw">
        <div class="sch on">📻 FM-ефір</div>
        <div class="sch"  @click.prevent="openModal">📿 Молитва</div>
      </div>
      <div class="ptog" @click="isDropOpen = !isDropOpen">☰ Розклад</div>
      <div class="embl" @click="openPopUpPlayer" style="cursor: pointer;">⧉ Вікно</div>
    </div>

    <div class="pdrop" :class="{ open: isDropOpen }" id="pdrop" v-if="playerState.liveProgramsToday && playerState.liveProgramsToday.length > 0">

      <div class="prow past" v-if="playerState.liveProgramIndex > 0">
        <div class="prow-t">{{ playerState.liveProgramsToday[playerState.liveProgramIndex - 1].time.substring(0,5) }}</div>
        <div class="prow-n">{{ playerState.liveProgramsToday[playerState.liveProgramIndex - 1].program?.name }}</div>
      </div>

      <div class="prow now" v-if="playerState.liveProgramIndex >= 0">
        <div class="prow-t">{{ playerState.liveProgramsToday[playerState.liveProgramIndex].time.substring(0,5) }}</div>
        <div class="prow-n">▶ {{ playerState.liveProgramsToday[playerState.liveProgramIndex].program?.name }}</div>
      </div>

      <div class="prow" v-if="playerState.liveProgramIndex + 1 < playerState.liveProgramsToday.length">
        <div class="prow-t">{{ playerState.liveProgramsToday[playerState.liveProgramIndex + 1].time.substring(0,5) }}</div>
        <div class="prow-n">{{ playerState.liveProgramsToday[playerState.liveProgramIndex + 1].program?.name }}</div>
      </div>

      <div class="prow" v-if="playerState.liveProgramIndex + 2 < playerState.liveProgramsToday.length">
        <div class="prow-t">{{ playerState.liveProgramsToday[playerState.liveProgramIndex + 2].time.substring(0,5) }}</div>
        <div class="prow-n">{{ playerState.liveProgramsToday[playerState.liveProgramIndex + 2].program?.name }}</div>
      </div>

    </div>

    <div class="pdrop" :class="{ open: isDropOpen }" id="pdrop" v-else>
      <div class="prow now">
        <div class="prow-n">Розклад відсутній або завантажується...</div>
      </div>
    </div>

    <div class="nav-bar">
      <a class="nl" href="#">Подкасти і архів</a>

      <!-- Обновленная ссылка для Программы -->
      <Link class="nl" :class="{ 'on': isProgramActive }" href="/#program">Програма</Link>

      <a class="nl" href="#" @click.prevent="openModal">Молитва</a>

      <Link class="nl" :class="{ 'on': isMissionActive }" href="/#mission">Місія</Link>

      <a class="nl" href="#">Для тих, хто шукає</a>
      <Link class="nl nl-listen" href="/live">
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