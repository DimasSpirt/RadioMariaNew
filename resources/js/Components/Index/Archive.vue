<script setup>
import { useSocials } from '@/Composables/useSocials';

const { renderedSocials } = useSocials();
</script>

<template>
  <div class="phub">
    <div class="phub-hdr">
      <div>
        <div class="phub-ey">
          <div class="phub-ey-bar"></div>
          <div class="phub-ey-text">Архів і подкасти</div>
        </div>
        <h2 class="phub-title">Слухайте коли <em>зручно</em></h2></div>
      <div class="phub-right">
        <div class="hsearch"><input type="text" placeholder="Пошук: назва, ведучий, тема...">
          <button class="hsb">
            <svg viewBox="0 0 16 16" stroke-width="1.8">
              <circle cx="7" cy="7" r="4.5"/>
              <line x1="10.5" x2="14" y1="10.5" y2="14"/>
            </svg>
          </button>
        </div>
        <a class="hall" href="#">Весь архів (1240)</a></div>
    </div>
    <div class="pfilters">
      <div class="pf on" onclick="setPf(this)">Всі</div>
      <div class="pf" onclick="setPf(this)">📖 Катехиза</div>
      <div class="pf" onclick="setPf(this)">🙏 Молитва</div>
      <div class="pf" onclick="setPf(this)">⛪ Свята Меса</div>
      <div class="pf" onclick="setPf(this)">📿 Розарій</div>
      <div class="pf" onclick="setPf(this)">🎙 Свідчення</div>
      <div class="pf" onclick="setPf(this)">📚 Духовне читання</div>
      <div class="pf" onclick="setPf(this)">✝️ Проповідь</div>
      <div class="pf pf-sp" onclick="this.classList.toggle('on')">
        <svg viewBox="0 0 14 14" fill="none">
          <circle cx="7" cy="7" r="6" fill="#1DB954"/>
          <polygon points="5,4 11,7 5,10" fill="white"/>
        </svg>
        Підписатись на Spotify
      </div>
    </div>
    <div class="pod-layout">
      <div class="pod-left">
        <div class="pfeat">
          <div class="pfeat-img"><img src="/images/img2.jpg" alt="Бог може пробачити">
            <div class="pfeat-ov"></div>
            <div class="pfeat-badge">⭐ Рекомендуємо</div>
            <div class="pfeat-play">
              <svg viewBox="0 0 20 20">
                <polygon points="5,3 17,10 5,17"/>
              </svg>
            </div>
            <div class="pfeat-dur">42:18</div>
          </div>
          <div class="pfeat-body">
            <div class="pfeat-tag">Катехиза</div>
            <div class="pfeat-title">Бог може пробачити навіть це...</div>
            <div class="pfeat-host">о. Тарас Франчук · Цикл «Боже Милосердя»</div>
            <div class="pfeat-meta">
              <div class="pfeat-date">07.05.2025</div>
              <div class="ppods">
                <div class="pp">Apple</div>
                <div class="pp">Spotify</div>
                <div class="pp">Telegram</div>
              </div>
            </div>
          </div>
        </div>
        <div class="pseries">
          <div class="pser-hd">
            <div class="pser-label">Цикл програм</div>
            <div class="pser-title">Фатіма сьогодні для України</div>
            <div class="pser-sub">о. Богдан · 12 серій</div>
          </div>
          <a class="sep" href="#" style="opacity:.5">
            <div class="sep-n done">✓</div>
            <div class="sep-i">
              <div class="sep-t">1. Таємниця Фатіми</div>
              <div class="sep-m">34 хв · 01.04.2025</div>
            </div>
            <div class="sep-b done">Прослухано</div>
          </a><a class="sep now" href="#">
          <div class="sep-n cur">▶</div>
          <div class="sep-i">
            <div class="sep-t">2. Фатіма: сьогодні для України</div>
            <div class="sep-m">38 хв · 08.04.2025</div>
          </div>
          <div class="sep-b cur">Зараз</div>
        </a><a class="sep" href="#">
          <div class="sep-n next">3</div>
          <div class="sep-i">
            <div class="sep-t">3. Послання Богородиці</div>
            <div class="sep-m">42 хв · 15.04.2025</div>
          </div>
        </a><a class="sep" href="#">
          <div class="sep-n next">4</div>
          <div class="sep-i">
            <div class="sep-t">4. Молитва і перемога</div>
            <div class="sep-m">36 хв · 22.04.2025</div>
          </div>
        </a>
          <div class="pser-foot"><a href="#">Всі 12 серій →</a></div>
        </div>
      </div>
      <div class="pod-right">
        <div class="prow3"><a class="pcard" href="#">
          <div class="pcard-img">
            <img src="/images/img3.jpg" alt="Фатіма">
            <div class="pcard-ov">
              <div class="pcard-play">
                <svg viewBox="0 0 10 10">
                  <polygon points="2,1 9,5 2,9"/>
                </svg>
              </div>
            </div>
            <div class="pcard-dur">38:10</div>
          </div>
          <div class="pcard-body">
            <div class="pcard-tag">📿 Катехиза</div>
            <div class="pcard-title">Фатіма: сьогодні для України</div>
            <div class="pcard-meta">
              <div class="pcard-date">08.04.2025</div>
              <div class="pcard-chips">
                <div class="pcc">Apple</div>
                <div class="pcc">Spotify</div>
              </div>
            </div>
          </div>
        </a><a class="pcard" href="#">
          <div class="pcard-img">
            <img src="/images/img4.jpg" alt="Свідчення">
            <div class="pcard-ov">
              <div class="pcard-play">
                <svg viewBox="0 0 10 10">
                  <polygon points="2,1 9,5 2,9"/>
                </svg>
              </div>
            </div>
            <div class="pcard-dur">29:45</div>
          </div>
          <div class="pcard-body">
            <div class="pcard-tag">🎙 Свідчення</div>
            <div class="pcard-title">Як Церква змінила наше подружжя</div>
            <div class="pcard-meta">
              <div class="pcard-date">02.05.2025</div>
              <div class="pcard-chips">
                <div class="pcc">Apple</div>
              </div>
            </div>
          </div>
        </a><a class="pcard" href="#">
          <div class="pcard-img" style="background:linear-gradient(135deg,#3d1a72,#5a2aa0)">
            <div class="pcard-ov">
              <div class="pcard-play">
                <svg viewBox="0 0 10 10">
                  <polygon points="2,1 9,5 2,9"/>
                </svg>
              </div>
            </div>
            <div class="pcard-dur">22:05</div>
          </div>
          <div class="pcard-body">
            <div class="pcard-tag">📿 Розарій</div>
            <div class="pcard-title">П'ятниця — Болісні таємниці Розарію</div>
            <div class="pcard-meta">
              <div class="pcard-date">09.05.2025</div>
              <div class="pcard-chips">
                <div class="pcc">Apple</div>
                <div class="pcc">Spotify</div>
              </div>
            </div>
          </div>
        </a></div>
        <div class="plist">
          <div class="plist-hd">
            <div class="plist-hd-t">Останні надходження</div>
            <div class="plist-hd-c">1 240 записів</div>
          </div>
          <a class="plr" href="#">
            <div class="plr-icon" style="background:linear-gradient(135deg,#1565a8,#2080cc)">
              <svg viewBox="0 0 14 14">
                <polygon points="2,1 12,7 2,13"/>
              </svg>
            </div>
            <div class="plr-info">
              <div class="plr-t">Недільні читання — Трійця — о. Тарас Франчук</div>
              <div class="plr-s">✝️ Проповідь · 18 хв · 08.05.2025</div>
            </div>
            <div class="plr-chips">
              <div class="plrc">Apple</div>
              <div class="plrc">Spotify</div>
            </div>
          </a><a class="plr" href="#">
          <div class="plr-icon" style="background:linear-gradient(135deg,#3d1a72,#5a2aa0)">
            <svg viewBox="0 0 14 14">
              <polygon points="2,1 12,7 2,13"/>
            </svg>
          </div>
          <div class="plr-info">
            <div class="plr-t">Коронка до Божого Милосердя — п'ятниця</div>
            <div class="plr-s">🙏 Молитва · 12 хв · 09.05.2025</div>
          </div>
          <div class="plr-chips">
            <div class="plrc">Apple</div>
          </div>
        </a><a class="plr" href="#">
          <div class="plr-icon" style="overflow:hidden">
            <img src="" alt="" style="width:100%;height:100%;object-fit:cover;object-position:80% 20%">
          </div>
          <div class="plr-info">
            <div class="plr-t">Фатіма: сьогодні для України — серія 2</div>
            <div class="plr-s">📿 Катехиза · 38 хв · 08.04.2025</div>
          </div>
          <div class="plr-chips">
            <div class="plrc">Spotify</div>
            <div class="plrc">Telegram</div>
          </div>
        </a><a class="plr" href="#">
          <div class="plr-icon" style="background:linear-gradient(135deg,#1e5631,#2a7a44)">
            <svg viewBox="0 0 14 14">
              <polygon points="2,1 12,7 2,13"/>
            </svg>
          </div>
          <div class="plr-info">
            <div class="plr-t">Псалом до душі — Перший Псалом</div>
            <div class="plr-s">📚 Духовне читання · 31 хв · 06.05.2025</div>
          </div>
          <div class="plr-chips">
            <div class="plrc">Spotify</div>
            <div class="plrc">Telegram</div>
          </div>
        </a><a class="plr" href="#">
          <div class="plr-icon" style="overflow:hidden">
            <img src="" alt=""
                 style="width:100%;height:100%;object-fit:cover;object-position:80% 20%">
          </div>
          <div class="plr-info">
            <div class="plr-t">Як Церква змінила наше подружжя</div>
            <div class="plr-s">🎙 Свідчення · 29 хв · 02.05.2025</div>
          </div>
          <div class="plr-chips">
            <div class="plrc">Apple</div>
          </div>
        </a></div>
      </div>
    </div>
  </div>

  <div class="sub-ban">
    <div>
      <div class="sub-title">Підписуйтесь на подкасти</div>
      <div class="sub-desc">Слухайте Радіо Марія де завгодно — в плеєрі, в дорозі, вдома</div>
    </div>

    <div class="sub-btns">
      <a
          v-for="social in renderedSocials"
          :key="'sub-' + social.id"
          class="sbb"
          :href="social.link"
          target="_blank"
          :style="social.name === 'RSS' ? 'border-color:rgba(200,168,75,.4);color:#e8c870' : ''"
      >
        {{ social.name }}
      </a>
    </div>

  </div>
</template>

<style scoped>

</style>