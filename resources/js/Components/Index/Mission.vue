<script setup lang="ts">
  import Map from "@/Components/Index/Map.vue";
</script>

<template>
  <div class="mission" id="mission">
    <div class="mission-img"><img src="/images/img5.jpg" alt="Паломники Радіо Марія">
      <div class="mission-img-ov"></div>
    </div>
    <div class="mission-c">
      <div class="mission-ey">
        <div class="mission-ey-bar"></div>
        <div class="mission-ey-t">Наша місія</div>
      </div>
      <div class="mission-title">Частина Світової<br>Родини Radio Maria</div>

      <!-- Logo + Big numbers -->
      <div
          style="display:flex;align-items:center;gap:16px;padding:14px;background:rgba(255,255,255,0.05);border:0.5px solid rgba(255,255,255,0.1);border-radius:10px;margin-bottom:16px">
        <img src="/images/img5.jpg" alt="Radio Maria"
             style="width:54px;height:54px;border-radius:50%;object-fit:cover;border:2px solid rgba(200,168,75,0.45);flex-shrink:0">
        <div style="display:flex;gap:16px;flex:1">
          <div style="text-align:center">
            <div
                style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:500;color:#c8a84b;line-height:1">
              95
            </div>
            <div
                style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-top:2px">
              Станцій
            </div>
          </div>
          <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
          <div style="text-align:center">
            <div
                style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:500;color:#c8a84b;line-height:1">
              83
            </div>
            <div
                style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-top:2px">
              Мови
            </div>
          </div>
          <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
          <div style="text-align:center">
            <div
                style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:500;color:#c8a84b;line-height:1">
              500M
            </div>
            <div
                style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-top:2px">
              Слухачів
            </div>
          </div>
        </div>
      </div>

      <Map />

      <ul class="mpts" style="margin-bottom:14px">
        <li class="mpt">Без реклами — лише на пожертви вірних</li>
        <li class="mpt">Молитва, катехиза та євангелізація 24/7</li>
        <li class="mpt">Марійський дух — Богородиця веде кожну програму</li>
      </ul>
      <a style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:rgba(255,255,255,.7);border-bottom:.5px solid rgba(255,255,255,.25);padding-bottom:2px;text-decoration:none"
         href="#">Дізнатись більше про нашу місію →</a>
    </div>
  </div>
  <div class="director"><img src="/images/img6.jpg" alt="о. Олексій Самсонов" class="dir-photo">
    <div>
      <div class="dir-role">Директор Радіо Марія Україна</div>
      <div class="dir-name">о. Олексій Самсонов</div>
      <div class="dir-quote">«Радіо Марія — це голос Богородиці в кожному домі. Ми несемо молитву, надію і присутність
        Церкви туди, куди не завжди може дійти священик.»
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>