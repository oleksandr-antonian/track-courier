<script setup>
import Header from '@/components/Header.vue';
</script>

<template>
  <div>
    <Header />
    <div class="p-4">
      <slot />
    </div>
  </div>
</template>

<style scoped>

</style>
