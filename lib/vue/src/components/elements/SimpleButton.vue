<template>
  <button class="simple-button" :class="{'red': color === 'red', 'with-spinner': props['spinner']}"><slot /></button>
</template>

<script setup lang="ts">

import {ref} from "vue";

interface Props {

  color?: string,
  spinner?: boolean

}

const props: Props = defineProps({
  color: {
    type: String,
    default: 'highlight'
  },
  spinner: {
    type: Boolean,
    default: false
  }
});

const color = ref(props.color);

</script>

<style scoped>
.simple-button {
  padding: 8px;
  margin-right: 5px;

  border: none;
  outline: none;
  cursor: pointer;
  border-radius: 3px;
  position: relative;
  display: inline-block;
  background-color: rgba(var(--highlight), .9);

  font-size: .95rem;
  line-height: .95rem;
  text-decoration: none;
  color: rgb(var(--white));
}

.red {
  background-color: rgba(var(--red), .9);
}

.simple-button:deep() i {
  margin-right: 5px;
}
</style>