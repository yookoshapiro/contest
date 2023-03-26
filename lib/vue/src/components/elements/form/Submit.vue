<template>
  <div class="input input-submit">
    <button type="submit">{{ text }}</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  name: string,
  text: string
}

const props: Props = defineProps({
  name: {
    type: String,
    required: true
  },
  text: {
    type: String,
    required: true
  }
});

const text = ref(props.text);

</script>