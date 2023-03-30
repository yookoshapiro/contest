<template>
  <router-view></router-view>
  <Notifications />
  <Alert />
</template>

<script setup lang="ts">
import Notifications from './components/elements/Notifications.vue';
import Alert from "./components/elements/Alert.vue";
</script>