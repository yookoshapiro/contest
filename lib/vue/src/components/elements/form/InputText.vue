<template>
  <label :for="inputId" :data-type="type" class="input input-text" :class="{ readonly, error, vertical, 'with-icon': icon }">
    <span class="label" v-if="label" >{{ label }}</span>
    <div class="input-field">
      <Icon v-if="icon" :name="icon" class="before" size="16" />
      <input :id="inputId" :name="name" :value="modelValue" @input="$emit('update:modelValue', eventValue($event))" :type="refType" :placeholder="placeholder" :readonly="readonly" />
      <div v-if="error" class="field-icon"><i class="icon icon-error-outline"></i></div>
      <div v-if="type === 'password' && refType === 'password'" class="toggle_password" @click="togglePassword"><Icon name="eye" size="16" title="Eingabe anzeigen" /></div>
      <div v-if="type === 'password' && refType === 'text'" class="toggle_password" @click="togglePassword"><Icon name="eye-slash" size="16" title="Eingabe ausblenden" /></div>
    </div>
    <div v-if="error" class="error-message">{{ error }}</div>
  </label>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Md5 } from "ts-md5";
import Icon from "../Icon.vue";

const eventValue = function(event: any): string {
  return (event.target as HTMLInputElement).value;
}

interface Props {
  name: string;
  label?: string;
  type?: string,
  modelValue?: string;
  error?: string;
  id?: string;
  placeholder?: string;
  readonly?: boolean,
  vertical?: boolean,
  icon?: string
}

const props: Props = defineProps({
  name: {
    type: String,
    required: true
  },
  label: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: "text"
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
  },
  icon: {
    type: String,
    default: null
  }
});

defineEmits(['update:modelValue']);

const inputId = ref( props.id ?? Md5.hashStr(props.name) );

const refType = ref(props.type);

const togglePassword = function() {
  refType.value === 'password' ? refType.value = 'text' : refType.value = 'password';
}

</script>