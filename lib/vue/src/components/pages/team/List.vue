<template>
  <div class="title">
    <h3>Teams</h3>
    <div class="controls">
      <LinkedButton :to="{name: 'addTeam'}">Team hinzufügen</LinkedButton>
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
              <LinkedButton :to="{name: 'editTeam', params: { id: team.id }}"><i class="icon icon-edit"></i>Bearbeiten</LinkedButton>
              <SimpleButton @click="deleteTeam(team.id)" color="red" :spinner="spinner.get(team.id)"><i class="icon icon-delete"></i>Löschen</SimpleButton>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">

import {onBeforeMount, ref} from 'vue';
import { teamsStore, stationsStore } from '../../../lib/store/stores';
import { Station, Team } from '../../../lib/interface/tables';

import SimpleButton from '../../elements/SimpleButton.vue';
import LinkedButton from '../../elements/LinkedButton.vue';

const teams = teamsStore();
const stations = stationsStore();
const spinner = ref(new Map<string, boolean>());

onBeforeMount(() =>
{
  teams.load();
  stations.load();

  for(let index in teams.teams) {
    spinner.value.set( teams.teams[ index ].id, false );
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

const deleteTeam = function(this: any, id: string)
{

  spinner.value.set(id, true);
  teams.remove(id);

}

</script>