<template>
  <div>
    <label :for="name">{{ description }}</label>
    <input :id="inputId" :name="name" v-model="content" type="text" />
    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  description: string;
  name: string;
  content: string;
  error?: string;
  id?: string;
}

const props: Props = defineProps({
  description: {
    type: String,
    required: true
  },
  name: {
    type: String,
    required: true
  },
  content: {
    type: String,
    required: true
  },
  error: {
    type: String,
    default: null
  },
  id: {
    type: String,
    default: null
  }
});

const inputId = ref(props.id ?? props.name);
const content = ref(props.content);
</script>