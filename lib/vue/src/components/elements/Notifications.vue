<template>
  <div id="notifications">
    <div v-for="[index, notification] in notifications.notifications">

      <div class="item" :class="notification.type">
        <div class="title"><Icon :name="notification.icon || 'info-circle'" class="before" />{{ notification.title }}</div>
        <div class="body">{{ notification.text }}</div>
        <div class="close" @click="notifications.remove(index)"><Icon name="x" class="alone" /></div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { NotificationsStore } from '../../lib/store/notifications';

const notifications = NotificationsStore();
</script>