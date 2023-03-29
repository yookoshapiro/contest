<template>
  <div id="system-alert" :class="{active: alert.active === true}" @click.self="cancel">

    <div v-if="alert.type === SystemAlertType.alert" class="message message-alert">
      <div class="body icon icon-error-outline">
        <div class="title">Feuerwehr Schlagsdorf löschen</div>
        <div class="text">Möchtest du wirklich das Team 'Feuerwehr Schlagsdorf' löschen?<br><br>Alle bereits hinterlegten Ergebnisse können dann nicht mehr wiederhergestellt werden.</div>
      </div>
      <button @click.self="cancel">OK</button>
    </div>

    <div v-if="alert.type === SystemAlertType.confirm" class="message message-confirm">
      <div class="body icon icon-dangerous">
        <div class="title">{{ alert.title }}</div>
        <div class="text">{{ alert.text }}</div>
      </div>
      <button class="button-confirm" @click.self="confirm">Löschen</button>
      <button class="button-cancel" @click.self="cancel">Abbrechen</button>
    </div>

    <div v-if="alert.type === SystemAlertType.custom" class="message message-custom">
      <div class="body"></div>
      <button class="button-confirm" @click.self="confirm">Löschen</button>
      <button class="button-cancel" @click.self="cancel">Abbrechen</button>
    </div>

  </div>
</template>

<script setup lang="ts">

import { systemAlertStore, SystemAlertType } from '../../lib/store/alert';

const alert = systemAlertStore();

const confirm = function () {
  alert.resolve(null);
  alert.unset();
}

const cancel = function () {
  alert.reject(null);
  alert.unset();
}

</script>