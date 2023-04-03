<template>
  <div class="input input-submit">
    <button type="submit" :class="{'with-spinner': props['spinner']}"><slot /></button>
  </div>
</template>

<script setup lang="ts">
import {ref} from 'vue';

interface Props {
  name: string,
  spinner?: boolean
}

const props: Props = defineProps({
  name: {
    type: String,
    required: true
  },
  spinner: {
    type: Boolean,
    default: false
  }
});
</script>