<script setup lang="ts">

</script>

<template>
  <!-- Interactive world map SVG -->
  <div
      style="background:rgba(255,255,255,0.04);border:0.5px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;margin-bottom:16px;overflow:hidden">
    <div
        style="font-size:9px;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px;text-align:center">
      Radio Maria у світі
    </div>
    <svg viewBox="0 0 420 200" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto">
      <!-- Ocean background -->
      <rect width="420" height="200" fill="#0d2a4a" rx="6"/>
      <!-- Continents - simplified shapes -->
      <!-- North America -->
      <path
          d="M 30 40 Q 45 30 75 35 Q 95 38 100 55 Q 105 70 95 90 Q 85 110 70 115 Q 55 118 45 108 Q 30 95 28 75 Z"
          fill="#1a4a70" opacity="0.85"/>
      <!-- South America -->
      <path d="M 68 120 Q 80 118 90 125 Q 100 135 98 155 Q 95 172 82 178 Q 68 182 60 170 Q 50 155 53 138 Z"
            fill="#1a4a70" opacity="0.85"/>
      <!-- Europe -->
      <path d="M 175 28 Q 195 24 210 30 Q 225 36 228 50 Q 225 62 210 65 Q 195 68 182 60 Q 170 52 172 40 Z"
            fill="#1a4a70" opacity="0.85"/>
      <!-- Africa -->
      <path
          d="M 185 72 Q 210 68 225 80 Q 240 95 238 120 Q 235 145 218 158 Q 200 168 185 160 Q 168 150 165 130 Q 162 108 168 90 Z"
          fill="#1a4a70" opacity="0.85"/>
      <!-- Asia -->
      <path
          d="M 228 22 Q 270 16 310 25 Q 340 32 355 50 Q 365 65 355 80 Q 345 95 318 98 Q 288 100 260 90 Q 235 80 228 62 Z"
          fill="#1a4a70" opacity="0.85"/>
      <!-- Australia -->
      <path
          d="M 318 120 Q 345 115 362 125 Q 375 135 372 152 Q 368 165 352 170 Q 335 172 322 162 Q 308 150 310 135 Z"
          fill="#1a4a70" opacity="0.85"/>
      <!-- Japan/East Asia islands -->
      <ellipse cx="355" cy="68" rx="8" ry="12" fill="#1a4a70" opacity="0.7"/>

      <!-- Radio Maria station dots - gold pulses -->
      <!-- Italy (origin) -->
      <circle cx="200" cy="45" r="5" fill="#c8a84b" opacity="0.9"/>
      <circle cx="200" cy="45" r="9" fill="none" stroke="#c8a84b" stroke-width="1" opacity="0.4"/>
      <circle cx="200" cy="45" r="13" fill="none" stroke="#c8a84b" stroke-width="0.5" opacity="0.2"/>
      <!-- Ukraine -->
      <circle cx="220" cy="38" r="3.5" fill="#c8a84b" opacity="0.85"/>
      <circle cx="220" cy="38" r="7" fill="none" stroke="#c8a84b" stroke-width="0.8" opacity="0.35"/>
      <!-- Poland -->
      <circle cx="205" cy="33" r="3" fill="#c8a84b" opacity="0.8"/>
      <!-- Spain -->
      <circle cx="180" cy="44" r="3" fill="#c8a84b" opacity="0.8"/>
      <!-- USA east -->
      <circle cx="72" cy="62" r="3.5" fill="#c8a84b" opacity="0.8"/>
      <!-- USA west -->
      <circle cx="45" cy="65" r="3" fill="#c8a84b" opacity="0.75"/>
      <!-- Brazil -->
      <circle cx="82" cy="138" r="3" fill="#c8a84b" opacity="0.8"/>
      <!-- Argentina -->
      <circle cx="75" cy="158" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Colombia -->
      <circle cx="70" cy="120" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Nigeria -->
      <circle cx="198" cy="105" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Kenya -->
      <circle cx="218" cy="118" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- India -->
      <circle cx="282" cy="80" r="3" fill="#c8a84b" opacity="0.8"/>
      <!-- Philippines -->
      <circle cx="338" cy="88" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Indonesia -->
      <circle cx="330" cy="115" r="2.5" fill="#c8a84b" opacity="0.7"/>
      <!-- Australia -->
      <circle cx="345" cy="140" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- South Korea -->
      <circle cx="347" cy="55" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Japan -->
      <circle cx="358" cy="52" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- France -->
      <circle cx="187" cy="40" r="2.5" fill="#c8a84b" opacity="0.8"/>
      <!-- Germany -->
      <circle cx="197" cy="35" r="2.5" fill="#c8a84b" opacity="0.8"/>
      <!-- Portugal -->
      <circle cx="175" cy="46" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Mexico -->
      <circle cx="55" cy="85" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Canada -->
      <circle cx="60" cy="48" r="2.5" fill="#c8a84b" opacity="0.7"/>
      <!-- Romania -->
      <circle cx="218" cy="43" r="2.5" fill="#c8a84b" opacity="0.75"/>
      <!-- Hungary -->
      <circle cx="210" cy="40" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Lithuania -->
      <circle cx="210" cy="30" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Slovak -->
      <circle cx="207" cy="37" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Ethiopia -->
      <circle cx="222" cy="108" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Tanzania -->
      <circle cx="218" cy="125" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Congo -->
      <circle cx="205" cy="118" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Bolivia -->
      <circle cx="78" cy="148" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Chile -->
      <circle cx="72" cy="162" r="2" fill="#c8a84b" opacity="0.7"/>
      <!-- Peru -->
      <circle cx="68" cy="140" r="2" fill="#c8a84b" opacity="0.7"/>

      <!-- Italy label -->
      <text x="200" y="58" fill="#c8a84b" font-size="6" text-anchor="middle" opacity="0.8" font-family="Arial">
        Ерба 1987
      </text>
      <!-- Ukraine label -->
      <text x="228" y="35" fill="rgba(255,255,255,0.7)" font-size="6" text-anchor="start" opacity="0.9"
            font-family="Arial">Україна
      </text>

      <!-- Legend -->
      <circle cx="14" cy="185" r="3" fill="#c8a84b" opacity="0.85"/>
      <text x="22" y="189" fill="rgba(255,255,255,0.4)" font-size="7" font-family="Arial">Станція Radio Maria
      </text>
    </svg>
  </div>
</template>

<style scoped>

</style>