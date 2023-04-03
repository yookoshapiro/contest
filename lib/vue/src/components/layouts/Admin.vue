<template>
  <div id="admin">
    <Navigation></Navigation>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script setup lang="ts">
import Navigation from "../Navigation.vue";
</script>

<style scoped>

</style>