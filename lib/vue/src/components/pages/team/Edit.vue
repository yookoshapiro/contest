<template>
  <div class="title">
    <h3>Team <span v-if="$route.name === 'addTeam'">hinzufügen</span><span v-else>bearbeiten</span></h3>
  </div>
  <div class="block">

    <InputText v-if="$route.name === 'editTeam'" name="id" :value="$route.params.id" label="Kennung" readonly />
    <InputText name="name" label="Name" placeholder="Name des Teams" error="" />
    <Submit name="submit_team" :text="$route.name === 'addTeam' ? 'Neues Team anlegen' : 'Team bearbeiten'" />

  </div>
</template>

<script setup lang="ts">
import InputText from '../../elements/form/InputText.vue';
import Submit from '../../elements/form/Submit.vue';

</script>

<style scoped>

</style>