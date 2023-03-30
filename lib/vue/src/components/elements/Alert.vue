<template>
  <div id="alert" :class="{active: alert.active}" @click.self="alert.reject">

    <div v-if="alert.type === AlertType.alert" class="message message-alert">
      <div class="body icon icon-error-outline">
        <div class="title">{{ alert.title }}</div>
        <div class="text">{{ alert.text }}</div>
      </div>
      <button @click.self="alert.reject">OK</button>
    </div>

    <div v-if="alert.type === AlertType.confirm" class="message message-confirm">
      <div class="body icon icon-dangerous">
        <div class="title">{{ alert.title }}</div>
        <div class="text">{{ alert.text }}</div>
      </div>
      <button class="button-confirm" @click.self="alert.resolve">Löschen</button>
      <button class="button-cancel" @click.self="alert.reject">Abbrechen</button>
    </div>

    <div v-if="alert.type === AlertType.custom" class="message message-custom">
      <div id="message-custom" class="body"></div>
      <button class="button-confirm" @click.self="alert.resolve">Bestätigen</button>
      <button class="button-cancel" @click.self="alert.reject">Abbrechen</button>
    </div>

  </div>
</template>

<script setup lang="ts">

import { AlertStore, AlertType } from '../../lib/store/alert';

const alert = AlertStore().alert;

</script>