<template>
  <div class="input input-text" :class="{ readonly, error, vertical }">
    <label :for="inputId">{{ label }}</label>
    <div class="input-field">
      <input :id="inputId" :name="name" :value="modelValue" @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" type="text" :placeholder="placeholder" :readonly="readonly" />
      <div v-if="error" class="field-icon"><i class="icon icon-error-outline"></i></div>
    </div>
    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  label: string;
  name: string;
  modelValue?: string;
  error?: string;
  id?: string;
  placeholder?: string;
  readonly?: boolean,
  vertical?: boolean
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
  modelValue: {
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
  },
  vertical: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);

const inputId = ref(props.id ?? props.name);
const placeholder = ref(props.placeholder);
const readonly = ref(props.readonly);
</script>