<template>
  <div class="title">
    <h3>Team <span v-if="$route.name === 'addTeam'">hinzufügen</span><span v-else>bearbeiten</span></h3>
  </div>
  <div class="block">

    <InputText name="name" content="" description="Name" error="" />

  </div>
</template>

<script setup lang="ts">
import InputText from '../../elements/form/InputText.vue';
</script>

<style scoped>

</style>