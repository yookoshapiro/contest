<template>
  <Teleport to="#message-custom" v-if="active">
    <slot />
  </Teleport>
</template>

<script setup lang="ts">

import { ref } from 'vue';

interface Props {
  active: boolean
}

const props: Props = defineProps({
  active: {
    type: Boolean,
    default: false
  }
});

const readonly = ref(props.active);

</script>