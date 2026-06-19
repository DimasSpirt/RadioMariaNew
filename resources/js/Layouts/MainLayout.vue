<script setup>
import { Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
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
        <a class="tsoc" href="https://www.facebook.com/radiomariaukraine/" target="_blank">
          <svg viewBox="0 0 16 16"><path d="M9 6h2V4a4 4 0 00-4 4v1H5v2h2v5h2v-5h2l.5-2H9V8a2 2 0 012-2z"/></svg>Facebook
        </a>
        <a class="tsoc" href="https://www.youtube.com/@RadioMariaUkraine" target="_blank">
          <svg viewBox="0 0 16 16"><rect x="1" y="3" width="14" height="10" rx="2.5"/><path d="M6.5 6l4 2-4 2V6z" fill="#0a1e3a"/></svg>YouTube
        </a>
        <a class="tsoc" href="#">
          <svg viewBox="0 0 16 16"><path d="M14 2L2 6.5l4 1.5 1.5 4L10 9l3 5V2z"/></svg>Telegram
        </a>
        <a class="tsoc" href="#">
          <svg viewBox="0 0 16 16"><rect x="2" y="2" width="12" height="12" rx="3"/><circle cx="8" cy="8" r="3"/><circle cx="11.5" cy="4.5" r=".75" fill="#0a1e3a"/></svg>Instagram
        </a>
      </div>
      <a class="donate-top" href="#">
        <svg viewBox="0 0 14 14" stroke-width="2"><line x1="7" y1="1" x2="7" y2="13"/><path d="M4 4c0-1.7 6-1.7 6 0s-6 2-6 4 6 1.7 6 0"/></svg>Підтримати радіо
      </a>
    </div>

    <Header />

    <!-- Уникальный контент каждой страницы -->
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
        <div>
          <div class="fbrand-row">
            <img src="/images/logo.jpg" alt="Радіо Марія">
            <span class="fbrand-name">Радіо Марія Україна</span>
          </div>
          <div class="fbrand-sub">Голос у твоєму домі · з 1987</div>
          <div class="fbrand-tag">Місіонерський медіа-проєкт Церкви. Частина Світової Родини Radio Maria.</div>
          <div class="ffreq">106.3 FM · Київ · Онлайн 24/7</div>
        </div>

        <div>
          <div class="fcol-title">СЛУХАТИ</div>
          <a class="flink" href="#">В ефірі зараз</a>
          <a class="flink" href="#">Розклад програм</a>
          <a class="flink" href="#">Архів і подкасти</a>
          <a class="flink" href="#">Потік молитви</a>
        </div>

        <div>
          <div class="fcol-title">МІСІЯ</div>
          <a class="flink" href="#">Про нас</a>
          <a class="flink" href="#">Для тих, хто шукає</a>
          <a class="flink" href="#">Молитовний куточок</a>
          <a class="flink" href="#">Контакти</a>
        </div>

        <div>
          <div class="fcol-title">ПІДТРИМАТИ</div>
          <a class="flink" style="color:var(--gold)" href="#">→ Пожертвувати</a>
          <a class="flink" href="#">Стати волонтером</a>
          <a class="flink" href="#">Молитися за нас</a>
          <a class="flink" href="#">Звіт 2024</a>
        </div>
      </div>

      <div class="fbot">
        <div class="fcopy">© 2025 Радіо Марія Україна</div>
        <!-- Вот тот самый код соцсетей из твоего файла -->
        <div class="fsocs">
          <a class="fsoc" href="#"><svg viewBox="0 0 16 16"><path d="M9 6h2V4a4 4 0 00-4 4v1H5v2h2v5h2v-5h2l.5-2H9V8a2 2 0 012-2z"/></svg></a>
          <a class="fsoc" href="#"><svg viewBox="0 0 16 16"><rect x="1" y="3" width="14" height="10" rx="2.5"/><path d="M6.5 6l4 2-4 2V6z" fill="#fff"/></svg></a>
          <a class="fsoc" href="#"><svg viewBox="0 0 16 16"><path d="M14 2L2 6.5l4 1.5 1.5 4L10 9l3 5V2z"/></svg></a>
          <a class="fsoc" href="#"><svg viewBox="0 0 16 16"><rect x="2" y="2" width="12" height="12" rx="3"/><circle cx="8" cy="8" r="3"/><circle cx="11.5" cy="4.5" r=".75" fill="#fff"/></svg></a>
        </div>
        <div class="fbl">
          <a href="#">Конфіденційність</a>
          <a href="#">Карта сайту</a>
        </div>
      </div>
    </footer>
  </div>
</template>