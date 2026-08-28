<script setup>
import { useForm } from '@inertiajs/vue3';
import { useIntensionModal } from '@/Composables/useIntensionModal';

const { isOpen, closeModal } = useIntensionModal();

const form = useForm({
  type: 1, // 1 - Молитовна лінія, 2 - Привітання
  name: '',
  text: '',
});

const submitIntension = () => {
  form.post('/intensions', {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      form.reset(); // Сбрасываем поля формы после успешной отправки
    },
    onError: () => {
      // Здесь можно добавить логику, если нужно что-то сделать при ошибке
    }
  });
};
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="isOpen" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <button class="modal-close-btn" type="button" @click="closeModal">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>

          <h2 class="modal-title">Написати в ефір</h2>
          <p class="modal-subtitle">Ваше повідомлення прочитають ведучі Радіо Марія</p>

          <form class="intension-form" @submit.prevent="submitIntension" novalidate>
            <div class="form-group">
              <label>Куди хочете звернутись</label>
              <div class="select-wrapper">
                <select v-model="form.type">
                  <option :value="1">Молитовна лінія</option>
                  <option :value="2">Привітання</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Ваше ім'я</label>
              <input
                  v-model="form.name"
                  type="text"
                  placeholder="Як до вас звертатись?"
                  :class="{ 'is-invalid': form.errors.name }"
                  @input="form.clearErrors('name')"
              />
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
              <label>Текст листа</label>
              <textarea
                  v-model="form.text"
                  placeholder="Введіть текст вашого звернення чи молитви..."
                  :class="{ 'is-invalid': form.errors.text }"
                  rows="4"
                  @input="form.clearErrors('text')"
              ></textarea>
            </div>

            <!-- Резервируем место под ошибку прямо перед кнопками -->
            <div class="error-msg" :class="{ 'is-visible': form.hasErrors || form.errors.message }">
              {{ form.errors.message || 'Будь ласка, перевірте правильність заповнення полів.' }}
            </div>

            <div class="modal-actions">
              <button type="button" class="btn-cancel" @click="closeModal">Скасувати</button>
              <button type="submit" class="btn-submit" :disabled="form.processing">
                {{ form.processing ? 'Відправка...' : 'Надіслати' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
/* Анимации */
.modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .modal-content, .modal-leave-active .modal-content { transition: transform 0.3s ease; }
.modal-enter-from .modal-content, .modal-leave-to .modal-content { transform: translateY(-20px) scale(0.95); }

/* Оверлей */
.modal-overlay {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(15, 33, 67, 0.6); backdrop-filter: blur(6px);
  display: flex; justify-content: center; align-items: center; z-index: 9999;
}

.modal-content {
  background: #ffffff; width: 100%; max-width: 460px;
  border-radius: 16px; padding: 32px; position: relative;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-close-btn {
  position: absolute; top: 16px; right: 16px; border: none;
  background: rgba(0, 0, 0, 0.05); border-radius: 50%;
  width: 32px; height: 32px; cursor: pointer; color: #64748b;
}

.modal-title { margin: 0 0 8px 0; font-size: 22px; font-weight: 700; color: #1e293b; }
.modal-subtitle { margin: 0 0 24px 0; font-size: 14px; color: #64748b; }

/* Форма */
.intension-form .form-group { margin-bottom: 20px; }
.intension-form label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 13px; color: #475569; text-transform: uppercase; }

.intension-form select, .intension-form input, .intension-form textarea {
  width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1;
  border-radius: 8px; font-family: inherit; font-size: 15px;
}

.intension-form input:focus, .intension-form textarea:focus {
  outline: none; border-color: #d4af37; box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
}

/* Ошибки валидации */
.is-invalid { border-color: #ef4444 !important; }

/* Плашка с ошибкой (невидимая по умолчанию) */
/* Плашка с ошибкой (невидимая по умолчанию) */
.error-msg {
  background: #fef2f2;
  color: #b91c1c;
  padding: 12px;
  border-radius: 8px;
  margin-bottom: 16px; /* Отступ от кнопок */
  font-size: 14px;
  line-height: 1.4;
  border: 1px solid #fecaca;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease;

  /* Новые правила: фиксируем высоту под 2 строки и центрируем текст */
  min-height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Класс для показа плашки */
.error-msg.is-visible {
  opacity: 1;
  visibility: visible;
}

/* Кнопки */
.modal-actions { display: flex; justify-content: flex-end; gap: 12px; }
.btn-cancel { background: transparent; border: 1px solid #cbd5e1; padding: 10px 20px; border-radius: 8px; cursor: pointer; }
.btn-submit { background: #d4af37; border: none; padding: 10px 24px; border-radius: 8px; cursor: pointer; color: #000; font-weight: 600; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
</style>