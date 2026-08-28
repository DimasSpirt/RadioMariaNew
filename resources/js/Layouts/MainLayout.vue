<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import IntensionModal from '@/Components/IntensionModal.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { useSocials } from '@/Composables/useSocials';
import { computed } from 'vue';

// Достаем отсортированный массив соцсетей
const { renderedSocials } = useSocials();

const page = usePage();
const bannersMap = computed(() => page.props.global?.banners || {});
const banners = computed(() => Object.values(bannersMap.value));

const googleBanner = computed(() =>
    banners.value.find((b) => b.id === 10 || b.code === 'google' || b.name === 'google')
);

const appleBanner = computed(() =>
    banners.value.find((b) => b.id === 11 || b.code === 'apple' || b.name === 'apple')
);
</script>

<template>
  <div>
    <div class="mlbl">✦ Радіо Марія Україна · Новий сайт 2025 · Реальні фотографії · Подкасти в центрі</div>

    <div class="topbar">
      <Link class="tlogo" href="/">
        <img src="/images/logo.jpg" alt="Радіо Марія">
        <span class="tlogo-name">Радіо Марія Україна</span>
        <span class="tlogo-freq">106.3 FM · Київ</span>
      </Link>

      <div class="tsocs">
        <a
            v-for="social in renderedSocials"
            :key="'top-' + social.id"
            class="tsoc"
            :href="social.link"
            target="_blank"
        >
          <svg viewBox="0 0 16 16" v-html="social.svg"></svg>{{ social.name }}
        </a>
      </div>

      <a class="donate-top" href="#">
        <svg viewBox="0 0 14 14" stroke-width="2"><line x1="7" y1="1" x2="7" y2="13"/><path d="M4 4c0-1.7 6-1.7 6 0s-6 2-6 4 6 1.7 6 0"/></svg>Підтримати радіо
      </a>
    </div>

    <Header />

    <main>
      <slot />
    </main>

    <div class="donate-strip">
      <div class="donate-text">
        <div class="donate-title">Радіо Марія живе лише на ваші пожертви</div>
        <div class="donate-desc">Без реклами. Тільки місія, молитва і ваша підтримка.</div>
      </div>
      <div>
        <div class="da-amounts">
          <button class="da">100 ₴</button>
          <button class="da on">200 ₴</button>
          <button class="da">500 ₴</button>
          <button class="da">1000 ₴</button>
        </div>
        <div class="da-custom">
          <div class="da-curr">₴</div>
          <input class="da-in" type="number" placeholder="Інша сума...">
          <button class="da-go">Підтримати →</button>
        </div>
        <div class="da-note">LiqPay · Картка · Apple Pay · Google Pay</div>
      </div>
    </div>

    <footer>
      <div class="fgrid">
        <!-- Колонка 1: Бренд -->
        <div>
          <div class="fbrand-row">
            <img src="/images/logo.jpg" alt="Радіо Марія">
            <span class="fbrand-name">Радіо Марія Україна</span>
          </div>
          <div class="fbrand-sub">Голос у твоєму домі · з 1987</div>
          <div class="fbrand-tag">Місіонерський медіа-проєкт Церкви. Частина Світової Родини Radio Maria.</div>
        </div>

        <!-- Колонка 2: Слухати -->
        <div>
          <div class="fcol-title">СЛУХАТИ</div>
          <a class="flink" href="#">В ефірі зараз</a>
          <a class="flink" href="#">Розклад програм</a>
          <a class="flink" href="#">Архів і подкасти</a>
          <a class="flink" href="#">Потік молитви</a>
        </div>

        <!-- Колонка 3: Місія -->
        <div>
          <div class="fcol-title">МІСІЯ</div>
          <a class="flink" href="#">Про нас</a>
          <a class="flink" href="#">Для тих, хто шукає</a>
          <a class="flink" href="#">Молитовний куточок</a>
          <a class="flink" href="#">Контакти</a>
        </div>

        <!-- Колонка 4: Підтримати -->
        <div>
          <div class="fcol-title">ПІДТРИМАТИ</div>
          <a class="flink" style="color:var(--gold)" href="#">→ Пожертвувати</a>
          <a class="flink" href="#">Стати волонтером</a>
          <a class="flink" href="#">Молитися за нас</a>
          <a class="flink" href="#">Звіт 2024</a>
        </div>

        <!-- Строка на всю ширину: Частота и кнопки (Вынесли из 1-й колонки!) -->
        <div class="ffreq-row">
          <div class="ffreq">106.3 FM · Київ · Онлайн 24/7</div>

          <div v-if="googleBanner || appleBanner" class="footer-stores">
            <a
                v-if="googleBanner"
                :href="googleBanner.url"
                target="_blank"
                class="store-btn-gold"
            >
              <svg class="store-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                <path d="M3.609 1.814L13.792 12 3.61 22.186a1.5 1.5 0 0 1-.61-1.21V3.024a1.5 1.5 0 0 1 .609-1.21zM15.208 13.414l2.122 2.122-10.49 6.057 8.368-8.179zm0-2.828l-8.368-8.179 10.49 6.057-2.122 2.122zm2.828 2.828l3.182 1.838a1 1 0 0 1 0 1.732l-3.182 1.838-2.122-2.122 2.122-2.122z"/>
              </svg>
              <div class="store-text">
                <span>Google Play</span>
                <strong>Завантажити</strong>
              </div>
            </a>

            <a
                v-if="appleBanner"
                :href="appleBanner.url"
                target="_blank"
                class="store-btn-gold"
            >
              <svg class="store-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.31c.65-.79 1.09-1.89.97-2.99-.94.04-2.08.63-2.75 1.42-.59.69-1.11 1.79-.97 2.86 1.05.08 2.11-.53 2.75-1.29z"/>
              </svg>
              <div class="store-text">
                <span>App Store</span>
                <strong>Завантажити</strong>
              </div>
            </a>
          </div>
        </div>
      </div>

      <div class="fbot">
        <div class="fcopy">© 2025 Радіо Марія Україна</div>

        <div class="fsocs">
          <a
              v-for="social in renderedSocials"
              :key="'bot-' + social.id"
              class="fsoc"
              :href="social.link"
              target="_blank"
          >
            <svg viewBox="0 0 16 16" v-html="social.svg"></svg>
          </a>
        </div>

        <div class="fbl">
          <a href="#">Конфіденційність</a>
          <a href="/sitemap.xml">Карта сайту</a>
        </div>
      </div>
    </footer>

    <IntensionModal />

    <FlashMessage />

  </div>
</template>

<style scoped>
.ffreq-row {
  grid-column: 1 / -1; /* Растягивает блок на всю ширину сетки (через все колонки) */
  display: flex;
  align-items: center;
  justify-content: space-between; /* Расталкивает частоту влево, а кнопки вправо */
  width: 100%;
  /* margin-top: 24px; /* Добавила чуть больше отступа сверху, чтобы не липло к тексту колонок */
}

.footer-stores {
  display: flex;
  gap: 8px;
}

.store-btn-gold {
  display: flex;
  align-items: center;
  gap: 8px; /* Чуть увеличили расстояние между иконкой и текстом */
  background: var(--gold);
  color: var(--dark);
  padding: 10px 16px; /* Сделали отступы как у больших кнопок */
  border-radius: 6px;
  text-decoration: none;
  transition: transform 0.2s ease, filter 0.2s ease;
  white-space: nowrap;
}

.store-btn-gold:hover {
  transform: translateY(-2px);
  filter: brightness(1.05);
}

.store-icon {
  flex-shrink: 0;
  fill: var(--dark);
  width: 20px; /* Увеличили иконку */
  height: 20px;
}

.store-text {
  display: flex;
  flex-direction: column;
  line-height: 1.1;
}

.store-text span {
  font-size: 9px; /* Сделали надпись Google Play/App Store читабельнее */
  font-weight: 700;
  text-transform: uppercase;
  opacity: 0.75;
}

.store-text strong {
  font-size: 13px; /* Укрупнили главное слово Завантажити */
  font-weight: 700;
}
</style>