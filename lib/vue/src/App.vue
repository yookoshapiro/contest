<template>
  <router-view></router-view>
  <Notifications />
  <SystemAlert />
</template>

<script setup lang="ts">
import Notifications from './components/elements/Notifications.vue';
import SystemAlert from "./components/elements/SystemAlert.vue";
</script>