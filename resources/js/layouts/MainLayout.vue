<script setup>
import Header from '@/components/Header.vue';
import { ref, defineProps, onMounted } from 'vue';

const header = ref(null);
const headerHeight = ref(0);

const props = defineProps({
  withHeader: {
    type: Boolean,
    default: true
  },
  space: {
    type: Boolean,
    default: true
  },
  fullHeight: {
    type: Boolean,
    default: false
  }
});

onMounted(() => {
  if (props.withHeader) {
    headerHeight.value = header.value.$el.clientHeight;
  }
});
</script>

<template>
  <div>
    <Header v-if="withHeader" ref="header" />
    <div :class="{'p-4': space}" :style="{ height: fullHeight ? 'calc(100vh - ' + headerHeight + 'px)' : 'auto' }">
      <slot />
    </div>
  </div>
</template>

<style scoped>

</style>
