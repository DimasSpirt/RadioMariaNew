<script setup>
import { ref, computed } from 'vue';
import { playerState } from '@/Store/player';

// Активная вкладка (дата YYYY-MM-DD)
const activeTab = ref(null);

// Получаем массив доступных дат из нашего глобального стейта безопасно
const availableDates = computed(() => {
  // Защита от undefined на этапе инициализации
  if (!playerState || !playerState.schedule) return [];

  const dates = Object.keys(playerState.schedule);

  // Если даты загрузились, а активный таб еще не выбран — ставим сегодняшний день
  if (dates.length > 0 && !activeTab.value) {
    activeTab.value = dates[0];
  }
  return dates;
});

// Получаем расписание конкретно для выбранного дня
const activeSchedule = computed(() => {
  if (!activeTab.value || !playerState.schedule || !playerState.schedule[activeTab.value]) {
    return [];
  }
  return playerState.schedule[activeTab.value];
});

// Красиво форматируем название вкладки
const formatTabName = (dateString, index) => {
  if (index === 0) return 'Сьогодні';

  const date = new Date(dateString);
  const days = ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
  return days[date.getDay()];
};

// Проверка, идет ли эта передача прямо сейчас (чтобы зажечь плашку ЗАРАЗ)
const isNowPlaying = (progTs) => {
  if (!availableDates.value || availableDates.value.length === 0) return false;

  const today = availableDates.value[0];

  // Если открыта не сегодняшняя вкладка — точно не "сейчас"
  if (activeTab.value !== today) return false;

  // Защита от выхода за пределы массива через опциональную цепочку
  const currentLiveProg = playerState.liveProgramsToday?.[playerState.liveProgramIndex];

  return currentLiveProg && currentLiveProg.ts === progTs;
};
</script>

<template>
  <div class="sched-sec">
    <div class="sched-inner">

      <div class="sched-list">
        <div class="sched-hd">
          <div class="sched-hd-t">Програма ефіру</div>

          <div class="dtabs" v-if="availableDates && availableDates.length > 0">
            <div
                v-for="(date, index) in availableDates"
                :key="date"
                class="dtab"
                :class="{ 'on': activeTab === date }"
                @click="activeTab = date"
            >
              {{ formatTabName(date, index) }}
            </div>
          </div>
        </div>

        <template v-if="activeSchedule && activeSchedule.length > 0">
          <a
              v-for="prog in activeSchedule"
              :key="prog.ts"
              class="si"
              :class="{ 'now': isNowPlaying(prog.ts) }"
              href="#"
              @click.prevent
          >
            <div class="si-t">{{ prog.time ? prog.time.substring(0, 5) : '' }}</div>
            <div class="si-i">
              <div class="si-title">{{ prog.program?.name || 'Прямий ефір' }}</div>
              <div class="si-desc" v-if="prog.program?.description">{{ prog.program.description }}</div>
            </div>

            <div class="now-chip" v-if="isNowPlaying(prog.ts)">ЗАРАЗ</div>
          </a>
        </template>

        <div v-else class="si" style="pointer-events: none;">
          <div class="si-i">
            <div class="si-title">Розклад для цього дня відсутній</div>
          </div>
        </div>

      </div>

      <div class="prayer-side">
        <div class="pr-icon">🙏</div>
        <div class="pr-title">Молитовний куточок</div>
        <div class="pr-desc">Тексти і аудіо — молися разом з Радіо Марія</div>

        <a class="pri" href="#">
          <div class="pri-ic">📿</div>
          <div class="pri-t">Розарій</div>
          <div class="pri-d">20 хв</div>
        </a>

        <a class="pri" href="#">
          <div class="pri-ic">✝️</div>
          <div class="pri-t">Коронка Б. Милосердя</div>
          <div class="pri-d">12 хв</div>
        </a>

        <a class="pri" href="#">
          <div class="pri-ic">🕊️</div>
          <div class="pri-t">Ангел Господній</div>
          <div class="pri-d">3 хв</div>
        </a>

        <a class="pri" href="#">
          <div class="pri-ic">🕯️</div>
          <div class="pri-t">Молитва за Україну</div>
          <div class="pri-d">5 хв</div>
        </a>

        <a class="pr-req" href="#">📨 Надіслати молитовне прохання →</a>
      </div>

    </div>
  </div>
</template>