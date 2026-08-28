<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');

// Отлавливаем flash-сообщение об успехе от Inertia
watch(() => page.props.flash?.success, (newMsg) => {
  if (newMsg) {
    message.value = newMsg;
    show.value = true;

    // Автоматически прячем через 4 секунды
    setTimeout(() => {
      show.value = false;
      // Очищаем пропс, чтобы при повторной отправке того же текста тост снова сработал
      page.props.flash.success = null;
    }, 4000);
  }
}, { immediate: true });
</script>

<template>
  <Teleport to="body">
    <Transition name="toast-slide">
      <div v-if="show" class="flash-toast">
        <div class="toast-icon">
          <!-- Золотая иконка галочки -->
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
        <div class="toast-content">
          <p class="toast-title">Успіх!</p>
          <p class="toast-text">{{ message }}</p>
        </div>
        <button class="toast-close" @click="show = false" aria-label="Закрити">
          <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
/* Позиционирование слева внизу */
.flash-toast {
  position: fixed;
  bottom: 24px;
  left: 24px;
  z-index: 10000;
  display: flex;
  align-items: center;
  background: #ffffff;
  /* Золотой акцент слева */
  border-left: 4px solid #d4af37;
  border-radius: 8px;
  padding: 16px 20px 16px 16px;
  width: max-content;
  max-width: 400px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  gap: 12px;
}

/* Иконка */
.toast-icon {
  color: #d4af37;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

/* Текст */
.toast-content {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.toast-title {
  margin: 0;
  font-weight: 700;
  font-size: 14px;
  color: #1e293b;
}

.toast-text {
  margin: 0;
  font-size: 13px;
  color: #64748b;
  line-height: 1.4;
}

/* Кнопка закрытия */
.toast-close {
  background: transparent;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  padding: 4px;
  margin-left: auto;
  border-radius: 4px;
  display: flex;
  align-items: center;
  transition: color 0.2s, background-color 0.2s;
}

.toast-close:hover {
  color: #1e293b;
  background: #f1f5f9;
}

/* Мягкая анимация выезда снизу-слева */
.toast-slide-enter-active,
.toast-slide-leave-active {
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.toast-slide-enter-from {
  opacity: 0;
  transform: translateX(-20px) translateY(10px);
}

.toast-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>