<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
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
        <Link class="hbp" href="/play">
          <svg viewBox="0 0 10 10">
            <polygon points="2,1 9,5 2,9"/>
          </svg>
          Слухати зараз
        </Link>
        <a class="hbs" href="#">🎧 Всі подкасти</a>
        <a class="hbs" href="#">🙏 Молитва</a>
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
            <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:2px">Молитися</div>
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
    </div>
  </div>

</template>