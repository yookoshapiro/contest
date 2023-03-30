<template>
  <router-link :to="to" class="linked-button" :class="{'red': color === 'red'}"><slot /></router-link>
</template>

<script setup lang="ts">

import {ref} from "vue";

interface Props {

  to: object;
  color?: string

}

const props: Props = defineProps({
  to: {
    type: Object,
    required: true
  },
  color: {
    type: String,
    default: 'highlight'
  }
});

const to = ref(props.to);
const color = ref(props.color);

</script>

<style scoped>
.linked-button {
  padding: 8px;
  margin-right: 5px;

  user-select: none;
  border-radius: 3px;
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

.linked-button:deep() i {
  margin-right: 5px;
}
</style>