<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import { useIntensionModal } from '@/Composables/useIntensionModal';
import { computed } from "vue";


const page = usePage();

const { openModal } = useIntensionModal();

const bannersMap = computed(() => page.props.global?.banners || {});
const banners = computed(() => Object.values(bannersMap.value));

const googleBanner = computed(() =>
    banners.value.find((b: any) => b.id === 10 || b.code === 'google' || b.name === 'google')
);

const appleBanner = computed(() =>
    banners.value.find((b: any) => b.id === 11 || b.code === 'apple' || b.name === 'apple')
);
</script>

<template>
  <div class="hero">
    <div class="hero-img">
      <img src="/images/img1.jpg" alt="Богородиця над Україною">
      <div class="hero-img-ov"></div>
    </div>
    <div class="hero-c">
      <div class="hrey">
        <div class="hrey-bar"></div>
        <div class="hrey-text">Радіо молитви та євангелізації</div>
      </div>
      <h1 class="htitle">Голос <em>Марії</em><br>у твоєму домі</h1>
      <p class="hsub">Молитва, катехиза і євангелізація цілодобово — на FM, онлайн і у подкастах. Без реклами, лише
        місія.</p>
      <div class="hbtns">
        <Link class="hbp" href="/live">
          <svg viewBox="0 0 10 10">
            <polygon points="2,1 9,5 2,9"/>
          </svg>
          Слухати зараз
        </Link>
        <a class="hbs" href="#">🎧 Всі подкасти</a>
        <a class="hbs" href="#" @click.prevent="openModal">🙏 Молитва</a>
      </div>

      <div class="hstats" style="margin-bottom:14px">
        <div class="hstat">
          <div class="hstat-n">106.3</div>
          <div class="hstat-l">FM Київ</div>
        </div>
        <div class="hstat">
          <div class="hstat-n">24/7</div>
          <div class="hstat-l">В ефірі</div>
        </div>
        <div class="hstat">
          <div class="hstat-n">95</div>
          <div class="hstat-l">Станцій</div>
        </div>
        <div class="hstat">
          <div class="hstat-n">1200+</div>
          <div class="hstat-l">Записів</div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <div
            style="background:rgba(255,255,255,0.08);border:0.5px solid rgba(255,255,255,0.13);border-radius:8px;padding:11px 13px;display:flex;align-items:flex-start;gap:9px">
          <span style="font-size:18px;flex-shrink:0;margin-top:1px">📻</span>
          <div>
            <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:2px">Слухати</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.5);line-height:1.4">FM-ефір і онлайн, sticky-плеєр,
              подкасти
            </div>
          </div>
        </div>
        <div
            style="background:rgba(255,255,255,0.08);border:0.5px solid rgba(255,255,255,0.13);border-radius:8px;padding:11px 13px;display:flex;align-items:flex-start;gap:9px">
          <span style="font-size:18px;flex-shrink:0;margin-top:1px">🙏</span>
          <div>
            <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:2px" @click.prevent="openModal">Молитися</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.5);line-height:1.4">Розарій, Коронка, Ангел Господній
              — щодня
            </div>
          </div>
        </div>
        <Link href="/#mission"
              style="text-decoration:none;color:#fff;background:rgba(255,255,255,0.08);border:0.5px solid rgba(255,255,255,0.13);border-radius:8px;padding:11px 13px;display:flex;align-items:flex-start;gap:9px">
          <span style="font-size:18px;flex-shrink:0;margin-top:1px">✦</span>
          <div>
            <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:2px">Місія</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.5);line-height:1.4">Частина Світової Родини Radio Maria</div>
          </div>
        </Link>
        <div
            style="background:rgba(255,255,255,0.08);border:0.5px solid rgba(255,255,255,0.13);border-radius:8px;padding:11px 13px;display:flex;align-items:flex-start;gap:9px">
          <span style="font-size:18px;flex-shrink:0;margin-top:1px">❤</span>
          <div>
            <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:2px">Підтримати</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.5);line-height:1.4">Без реклами — лише ваші пожертви
            </div>
          </div>
        </div>
      </div>

      <!-- Кнопки приложений с использованием системных переменных --gold и --dark -->
      <div v-if="googleBanner || appleBanner" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 8px;">
        <a
            v-if="googleBanner"
            :href="googleBanner.url"
            target="_blank"
            class="store-btn-gold"
        >
          <svg class="store-icon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
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
          <svg class="store-icon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
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
</template>

<style scoped>
.store-btn-gold {
  display: flex;
  align-items: center;
  gap: 12px;
  background: var(--gold);
  color: var(--dark);
  padding: 16px 20px; /* Подогнали вертикальные и горизонтальные отступы под кнопки выше */
  border-radius: 8px; /* Сделали скругление таким же гармоничным */
  text-decoration: none;
  transition: transform 0.2s ease, filter 0.2s ease;
  flex: 1; /* Растягивает кнопку на всю доступную ширину колонки */
}

.store-btn-gold:hover {
  transform: translateY(-2px);
  filter: brightness(1.05);
}

.store-icon {
  flex-shrink: 0;
  fill: var(--dark);
  width: 24px; /* Сделали иконку пропорциональной новой высоте */
  height: 24px;
}

.store-text {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

.store-text span {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  opacity: 0.75;
}

.store-text strong {
  font-size: 14px;
  font-weight: 700;
}
</style>