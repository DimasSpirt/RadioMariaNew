<script setup>
import { Head } from '@inertiajs/vue3';
import { playerState } from '@/Store/player';

defineProps({
  streams: Object
});
</script>

<template>
  <Head title="Радіо Марія - Прямий ефір" />

  <div class="max-w-[1200px] mx-auto px-4 lg:px-8 py-16 min-h-[70vh] flex flex-col items-center">

    <div class="mb-4 inline-flex items-center gap-2">
      <div class="w-8 h-1 bg-[var(--gold)]"></div>
      <div class="font-bold tracking-widest text-sm uppercase text-[var(--muted)]">Слухати онлайн</div>
      <div class="w-8 h-1 bg-[var(--gold)]"></div>
    </div>

    <h1 class="htitle text-4xl md:text-5xl !text-[var(--dark)] mb-6 text-center">Прямий ефір</h1>
    <p class="text-[var(--text)] text-lg text-center mb-16 max-w-2xl opacity-80">
      Оберіть зручну якість трансляції або дивіться нас наживо на YouTube.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 w-full mb-16">

      <div class="bg-white rounded-3xl shadow-sm border border-[var(--border)] p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-[var(--blue)] text-white rounded-full flex items-center justify-center mb-6">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
        </div>
        <h3 class="htitle text-2xl !text-[var(--dark)] mb-2">Висока якість</h3>
        <p class="text-[var(--muted)] text-sm mb-8">160 kbps • Для стабільного інтернету</p>

        <button
            @click="playerState.toggle({ url: streams.stream160, type: 'live', title: 'Прямий ефір', subtitle: '160 kbps • Висока якість' })"
            class="mt-auto w-16 h-16 rounded-full flex items-center justify-center transition-all shadow-md"
            :class="playerState.isPlaying && playerState.currentStream === streams.stream160 ? 'bg-[var(--gold)] text-[var(--dark)]' : 'bg-[var(--blue)] text-white hover:scale-105'"
        >
          <svg v-if="!(playerState.isPlaying && playerState.currentStream === streams.stream160)" class="w-8 h-8 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
          <svg v-else class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
        </button>
      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-[var(--border)] p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-[var(--light)] text-[var(--blue)] rounded-full flex items-center justify-center mb-6 border border-[var(--border)]">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
        </div>
        <h3 class="htitle text-2xl !text-[var(--dark)] mb-2">Середня якість</h3>
        <p class="text-[var(--muted)] text-sm mb-8">64 kbps • Оптимально для дороги</p>

        <button
            @click="playerState.toggle({ url: streams.stream64, type: 'live', title: 'Прямий ефір', subtitle: '64 kbps • Середня якість' })"
            class="mt-auto w-16 h-16 rounded-full flex items-center justify-center transition-all shadow-md"
            :class="playerState.isPlaying && playerState.currentStream === streams.stream64 ? 'bg-[var(--gold)] text-[var(--dark)]' : 'bg-[var(--light)] border border-[var(--border)] text-[var(--blue)] hover:scale-105'"
        >
          <svg v-if="!(playerState.isPlaying && playerState.currentStream === streams.stream64)" class="w-8 h-8 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
          <svg v-else class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
        </button>
      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-[var(--border)] p-8 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-[var(--light)] text-[var(--blue)] rounded-full flex items-center justify-center mb-6 border border-[var(--border)]">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
        </div>
        <h3 class="htitle text-2xl !text-[var(--dark)] mb-2">Економія даних</h3>
        <p class="text-[var(--muted)] text-sm mb-8">32 kbps • Для повільного зв'язку</p>

        <button
            @click="playerState.toggle({ url: streams.stream32, type: 'live', title: 'Прямий ефір', subtitle: '32 kbps • Економія даних' })"
            class="mt-auto w-16 h-16 rounded-full flex items-center justify-center transition-all shadow-md"
            :class="playerState.isPlaying && playerState.currentStream === streams.stream32 ? 'bg-[var(--gold)] text-[var(--dark)]' : 'bg-[var(--light)] border border-[var(--border)] text-[var(--blue)] hover:scale-105'"
        >
          <svg v-if="!(playerState.isPlaying && playerState.currentStream === streams.stream32)" class="w-8 h-8 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
          <svg v-else class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
        </button>
      </div>

    </div>

    <a v-if="streams.youtube" :href="streams.youtube" target="_blank" class="group bg-[#FF0000] text-white px-8 py-4 rounded-full font-bold tracking-wide flex items-center gap-3 hover:bg-red-700 transition-colors shadow-lg hover:shadow-red-500/30">
      <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
      Дивитись на YouTube
    </a>

  </div>
</template>