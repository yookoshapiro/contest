<template>

  <div class="title">
    <h1>Teams</h1>
    <div class="controls">
      <SimpleButton @click="showAddTeam"><Icon name="person-fill-add" class="inline" /><span>Team hinzufügen</span></SimpleButton>
    </div>
  </div>

  <div class="content">
    <div class="block">
      <table>
        <thead>
          <tr>
            <td class="width-40">#</td>
            <td>Team</td>
            <td>Stationen</td>
            <td>Aktionen</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(team, index) in teams.teams">
            <td>{{ index+1 }}</td>
            <td>{{ team.name }}</td>
            <td>{{ team.results.length }} / {{ stations.stations.length }}</td>
            <td>
              <SimpleButton @click="showEditTeam(team.id, team.name)" :spinner="editSpinner.get(team.id)" title="Bearbeiten"><Icon name="pencil-fill" /></SimpleButton>
              <SimpleButton @click="deleteTeam(team.id, team.name)" color="red" :spinner="deleteSpinner.get(team.id)" title="Löschen"><Icon name="trash-fill" /></SimpleButton>
            </td>
          </tr>
          <tr v-if="showAddSpinner">
            <td>X</td>
            <td colspan="3"><div class="with-spinner">Wird angelegt</div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <CustomAlert :active="activateAlert">
    <div>
      <Icon :name="inputIconName" class="before" />
      <div style="padding-left: 60px">
        <div style="margin-bottom: 10px">{{ inputLabel }}</div>
        <InputText v-model="teamName" name="name" placeholder="Name des Teams" vertical />
      </div>
    </div>
  </CustomAlert>

</template>

<script setup lang="ts">

import {onBeforeMount, ref} from 'vue';
import {Station, Team} from '../../lib/interface/Tables';

import {teamsStore} from '../../lib/store/data/teams';
import {stationsStore} from '../../lib/store/data/stations';
import {AlertStore, AlertTheme, AlertType} from '../../lib/store/alert';
import {NotificationsStore, NotificationType} from "../../lib/store/notifications";

const teams = teamsStore();
const stations = stationsStore();

const alert = AlertStore();
const notifications = NotificationsStore();

const activateAlert = ref(false);
const teamName = ref('');
const inputLabel = ref('');
const inputIconName = ref('');

const showAddSpinner = ref(false);
const editSpinner = ref(new Map<string, boolean>());
const deleteSpinner = ref(new Map<string, boolean>());


onBeforeMount(() =>
{

  stations.load();
  teams.load().then(() =>
  {

    for(let index in teams.teams)
    {

      editSpinner.value.set( teams.teams[ index ].id, false );
      deleteSpinner.value.set( teams.teams[ index ].id, false );

    }

  });

});


const showAddTeam = function(): void
{

  activateAlert.value = true;
  teamName.value = '';
  inputLabel.value = 'Team hinzufügen';
  inputIconName.value = 'person-fill-add';

  alert.set({type: AlertType.custom})
    .then((response) => {

      activateAlert.value = false;
      inputLabel.value = '';

      if (teamName.value === "")
      {

        notifications.add({
          type: NotificationType.warning,
          title: 'Kein neues Team anlegt',
          text: "Es wurde kein neues Team angelegt, da das Feld mit dem Namen leer war."
        });

        return response;

      }

      showAddSpinner.value = true;

      return teams.add(teamName.value).then((result) =>
      {

        editSpinner.value.set( result.data.data.id, false );
        deleteSpinner.value.set( result.data.data.id, false );

        showAddSpinner.value = false;
        notifications.add({
          type: NotificationType.success,
          title: 'Team angelegt',
          text: "Das Team '" +teamName.value + "' wurde erfolgreich angelegt."
        });

      });

    })
    .catch(() => {
      activateAlert.value = false;
    });

}


const showEditTeam = function(id: string, name: string): void
{

  activateAlert.value = true;
  teamName.value = name;
  inputLabel.value = 'Team bearbeiten';
  inputIconName.value = 'pencil-fill';

  alert.set({type: AlertType.custom})
    .then(() => {

      activateAlert.value = false;
      inputLabel.value = '';
      editSpinner.value.set(id, true);

      if (name !== teamName.value) {

        return teams.edit(id, teamName.value).then(() => {
          notifications.add({
            type: NotificationType.success,
            title: 'Team bearbeitet',
            text: "Das Team '" + name + "' wurde zu '" +teamName.value + "' umbenannt."
          });
        });

      }

      notifications.add({
        type: NotificationType.warning,
        title: 'Team nicht bearbeitet',
        text: "Der Name des Teams '" + name + "' wurde nicht geändert."
      });

    })
    .catch(() => {
      activateAlert.value = false;
    })
    .finally(() => {
      editSpinner.value.set(id, false);
    });

}


const deleteTeam = function(id: string, name: string): void
{

  alert.set({
    type: AlertType.confirm,
    title: 'Team wirklich löschen?',
    text: "Soll das Team '" + name + "' wirklich gelöscht werden?",
    theme: AlertTheme.red
  })
    .then(() => {

      deleteSpinner.value.set(id, true);

      return teams.remove(id).then(() =>
      {
        notifications.add({
          type: NotificationType.error,
          title: 'Team entfernt',
          text: "Das Team '" + name + "' wurde gelöscht."
        });
      });

    })
    .catch(() => {})
    .finally(() => {
      deleteSpinner.value.set(id, false);
    });

}


const showStation = function(station: Station, team: Team): void
{

  console.log(station, team);

}

</script>