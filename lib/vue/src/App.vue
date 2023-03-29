<template>
  <router-view></router-view>
  <SystemMessages />
  <SystemAlert />
</template>

<script setup lang="ts">
import SystemMessages from './components/elements/SystemMessages.vue';
import SystemAlert from "./components/elements/SystemAlert.vue";
</script>