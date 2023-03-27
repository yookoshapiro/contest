<template>
  <div id="system-messages">
    <div v-for="(message, index) in messages.messages">

      <div class="item" :class="message.type">
        <div class="title icon" :class="icons[ message.type ]">{{ message.title }}</div>
        <div class="body">{{ message.text }}</div>
        <div class="close"><i class="icon icon-close" @click="getClose(index)" /></div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { systemMessagesStore } from '../../lib/store/message';

const messages = systemMessagesStore();
const icons = {
  'warning': 'icon-error-outline',
  'error': 'icon-dangerous',
  'success': 'icon-check_circle',
  'info': 'icon-circle_notifications'
};

const getClose = function(index: number) {
  messages.remove(index);
}

</script>