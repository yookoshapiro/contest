<template>
  <div id="notifications">
    <div v-for="notification in notifications.messages">

      <div class="item" :class="notification.type">
        <div class="title icon" :class="icons[ notification.type ]">{{ notification.title }}</div>
        <div class="body">{{ notification.text }}</div>
        <div class="close" @click="removeItem(notification.created_at)"><i class="icon icon-close" /></div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { NotificationsStore } from '../../lib/store/notifications';

const notifications = NotificationsStore();
const icons = {
  'warning': 'icon-error-outline',
  'error': 'icon-dangerous',
  'success': 'icon-check_circle',
  'info': 'icon-circle_notifications'
};

const removeItem = function(timestamp: number) {
  notifications.remove(timestamp);
}
</script>