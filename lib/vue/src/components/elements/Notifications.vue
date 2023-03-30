<template>
  <div id="notifications">
    <div v-for="[index, notification] in notifications.notifications">

      <div class="item" :class="notification.type">
        <div class="title icon" :class="notification.icon">{{ notification.title }}</div>
        <div class="body">{{ notification.text }}</div>
        <div class="close" @click="notifications.remove(index)"><i class="icon icon-close" /></div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { NotificationsStore } from '../../lib/store/notifications';

const notifications = NotificationsStore();
</script>