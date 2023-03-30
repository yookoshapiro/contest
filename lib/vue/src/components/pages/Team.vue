<template>
  <div class="title">
    <h3>Teams</h3>
    <div class="controls">
      <SimpleButton @click="showAddTeam">Team hinzufügen</SimpleButton>
    </div>
  </div>

  <div class="content">
    <div class="block">
      <div class="body table">
        <table>
          <thead>
          <tr>
            <td style="width: 40px">#</td>
            <td style="width: 400px">Team</td>
            <td style="width: 400px">Ergebnisse</td>
            <td style="min-width: 150px;">Aktionen</td>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(team, index) in teams.teams">
            <td>{{ index+1 }}</td>
            <td>
              <div style="margin-bottom: 10px;">{{ team.name }}</div>
              <div class="little">{{ team.id }}</div>
            </td>
            <td>
              <div v-for="station in stations.stations" class="list-inline">
                <router-link :to="{ name: 'showStation', params: { id: station.id } }">
                  <div v-if="isIn(station, team)" :title="station.name" class="list-inline-item done"><i class="icon icon-done"></i></div>
                  <div v-else :title="station.name" class="list-inline-item"><i class="icon icon-location"></i></div>
                </router-link>
              </div>
            </td>
            <td>
              <SimpleButton @click="showEditTeam(team.id, team.name)" :spinner="editSpinner.get(team.id)"><i class="icon icon-edit" />Bearbeiten</SimpleButton>
              <SimpleButton @click="deleteTeam(team.id, team.name)" color="red" :spinner="deleteSpinner.get(team.id)"><i class="icon icon-delete" />Löschen</SimpleButton>
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
  </div>

  <CustomAlert :active="activateAlert">
    <InputText v-model="teamName" name="name" :label="inputLabel" placeholder="Name des Teams" vertical />
  </CustomAlert>
</template>

<script setup lang="ts">

import { onBeforeMount, ref } from 'vue';
import { Station, Team } from '../../lib/interface/Tables';

import { stationsStore, teamsStore } from '../../lib/store/stores';
import { AlertStore, AlertType } from '../../lib/store/alert';
import { NotificationsStore, NotificationType } from "../../lib/store/notifications";

import SimpleButton from "../elements/SimpleButton.vue";
import CustomAlert from "../elements/CustomAlert.vue";
import InputText from "../elements/form/InputText.vue";

const teams = teamsStore();
const stations = stationsStore();

const alert = AlertStore();
const notifications = NotificationsStore();

const activateAlert = ref(false);
const teamName = ref('');
const inputLabel = ref('');

const showAddSpinner = ref(false);
const editSpinner = ref(new Map<string, boolean>());
const deleteSpinner = ref(new Map<string, boolean>());

onBeforeMount(() =>
{

  teams.load();
  stations.load();

  for(let index in teams.teams) {
    editSpinner.value.set( teams.teams[ index ].id, false );
    deleteSpinner.value.set( teams.teams[ index ].id, false );
  }

});

const isIn = function(station: Station, team: Team): boolean
{

  if (typeof team.results === "undefined") {
    return false;
  }

  if (team.results?.length === 0) {
    return false;
  }

  const result = team.results?.filter((result) => {
    return result.station_id === station.id;
  });

  if (typeof result === "undefined") {
    return false;
  }

  return result.length > 0;

};

const showAddTeam = function(): void
{

  activateAlert.value = true;
  teamName.value = '';
  inputLabel.value = 'Team hinzufügen';

  alert.set({type: AlertType.custom})
    .then(() => {

      activateAlert.value = false;
      inputLabel.value = '';
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
    text: "Soll das Team '" + name + "' wirklich gelöscht werden?"
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

</script>