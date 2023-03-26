<template>
  <div :class="'input input-submit' + (readonly ? ' readonly' : '')">
    <label :for="inputId">{{ label }}</label>
    <div class="input-field">
      <input :id="inputId" :name="name" v-model="value" type="text" :placeholder="placeholder" :readonly="readonly" />
    </div>
    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  label: string;
  name: string;
  value?: string;
  error?: string;
  id?: string;
  placeholder?: string;
  readonly?: boolean
}

const props: Props = defineProps({
  label: {
    type: String,
    required: true
  },
  name: {
    type: String,
    required: true
  },
  value: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  id: {
    type: String,
    default: null
  },
  placeholder: {
    type: String,
    default: null
  },
  readonly: {
    type: Boolean,
    default: false
  }
});

const inputId = ref(props.id ?? props.name);
const value = ref(props.value);
const placeholder = ref(props.placeholder);
const readonly = ref(props.readonly);
</script>