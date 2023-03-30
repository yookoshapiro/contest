<template>
  <div id="system-alert" :class="{active: alert.active === true}" @click.self="alert.reject">

    <div v-if="alert.type === SystemAlertType.alert" class="message message-alert">
      <div class="body icon icon-error-outline">
        <div class="title">{{ alert.title }}</div>
        <div class="text">{{ alert.text }}</div>
      </div>
      <button @click.self="alert.reject">OK</button>
    </div>

    <div v-if="alert.type === SystemAlertType.confirm" class="message message-confirm">
      <div class="body icon icon-dangerous">
        <div class="title">{{ alert.title }}</div>
        <div class="text">{{ alert.text }}</div>
      </div>
      <button class="button-confirm" @click.self="alert.resolve">Löschen</button>
      <button class="button-cancel" @click.self="alert.reject">Abbrechen</button>
    </div>

    <div v-if="alert.type === SystemAlertType.custom" class="message message-custom">
      <div id="message-custom" class="body"></div>
      <button class="button-confirm" @click.self="alert.resolve">Bestätigen</button>
      <button class="button-cancel" @click.self="alert.reject">Abbrechen</button>
    </div>

  </div>
</template>

<script setup lang="ts">

import { onMounted, onUnmounted } from 'vue';
import { systemAlertStore, SystemAlertType } from '../../lib/store/alert';

const alert = systemAlertStore();

</script>