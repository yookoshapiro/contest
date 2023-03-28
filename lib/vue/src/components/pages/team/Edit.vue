<template>
  <div class="title">
    <h3>Team <span v-if="$route.name === 'addTeam'">hinzufügen</span><span v-else>bearbeiten</span></h3>
  </div>
  <div class="block">

    <form method="post" :action="$route.path" @submit.prevent="onSubmit">
      <InputText v-if="$route.name === 'editTeam'" name="id" :modelValue="$route.params.id.toString()" label="Kennung" readonly />
      <InputText v-model="teamName" name="name" label="Name" placeholder="Name des Teams" :error="error" />
      <Submit name="submit_team" :text="$route.name === 'addTeam' ? 'Neues Team anlegen' : 'Team bearbeiten'" :spinner="spinner" />
    </form>

  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { AxiosResponse } from 'axios';
import { teamsStore } from '../../../lib/store/stores';
import { systemMessagesStore, SystemMessageType } from '../../../lib/store/message';

import InputText from '../../elements/form/InputText.vue';
import Submit from '../../elements/form/Submit.vue';

const $route = useRoute();
const $router = useRouter();
const error = ref('');
const teamName = ref('');
const teams = teamsStore();
const spinner = ref(false);
const systemMessage = systemMessagesStore();

if ($route.name === "editTeam") {
  teams.find( $route.params.id.toString() ).then((response: AxiosResponse<any>) => {
    teamName.value = response.data.data.name;
  });
}

const onSubmit = function()
{

  error.value = "";
  spinner.value = true;

  if ( teamName.value.length === 0 ) {
    error.value = "Das Feld darf nicht leer sein.";
    return;
  }

  if ( teamName.value.length < 3 ) {
    error.value = "Der Name muss min. 3 Zeichen lang sein.";
    return;
  }

  if ($route.name === "addTeam")
  {

    return teams.add(teamName.value).then(() => {
      $router.push({name: 'showTeams'});
      spinner.value = false;
      systemMessage.add({
        type: SystemMessageType.success,
        title: 'Team angelegt',
        text: "Das Team '" +teamName.value + "' wurde erfolgreich angelegt."
      });
    });

  }

  return teams.edit($route.params.id.toString(), teamName.value).then(() => {
    $router.push({name: 'showTeams'});
    spinner.value = false;
    systemMessage.add({
      type: SystemMessageType.success,
      title: 'Team bearbeitet',
      text: "Das Team '" +teamName.value + "' wurde erfolgreich bearbeitet."
    });
  });

}

</script>