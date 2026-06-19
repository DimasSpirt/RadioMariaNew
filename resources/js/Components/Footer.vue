<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <footer>
    <div class="fgrid">
      <div>
        <div class="fbrand-row">
          <span class="fbrand-name">Радіо Марія Україна</span>
        </div>
        <div class="fbrand-sub">ХРИСТИЯНСЬКЕ РАДІО</div>
        <div class="fbrand-tag">Радіо молитви та євангелізації. Працює завдяки пожертвам слухачів.</div>
        <div class="ffreq">В ефірі</div>
      </div>
      <div>
        <div class="fcol-title">Програми</div>
        <Link href="#" class="flink">Катехиза</Link>
        <Link href="#" class="flink">Молитва</Link>
      </div>
    </div>
    <div class="fbot">
      <div class="fcopy">© 2025 Радіо Марія Україна. Всі права захищені.</div>
    </div>
  </footer>
</template>