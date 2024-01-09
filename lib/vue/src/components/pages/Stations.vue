<template>

  <div class="title">
    <h1>Stations</h1>
    <div class="controls padding-right-10">
      <SimpleButton @click="showAddStation" class="stand-alone"><Icon name="person-fill-add" class="inline" /><span>Station hinzufügen</span></SimpleButton>
    </div>
  </div>

  <div class="content">
    <div class="block">
      <table>
        <thead>
          <td class="text-center width-40">#</td>
          <td>Station</td>
          <td>Teams</td>
          <td>Aktionen</td>
        </thead>
        <tbody>
          <tr v-for="station in stations.stations">
            <td class="text-center">{{ station.index }}</td>
            <td>{{ station.name }}</td>
            <td>
            </td>
            <td>
              <SimpleButton @click="showEditStation(station.id, station.name)" title="Bearbeiten"><Icon name="pencil-fill" /></SimpleButton>
              <SimpleButton @click="showDeleteStation(station.id, station.name)" color="red" title="Löschen"><Icon name="trash-fill" /></SimpleButton>
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

</template>

<script setup lang="ts">

import {onBeforeMount, ref} from 'vue';
import {Station, Team} from '../../lib/interface/Tables';

import {teamsStore} from '../../lib/store/data/teams';
import {stationsStore} from '../../lib/store/data/stations';

const teams = teamsStore();
const stations = stationsStore();

const showAddSpinner = ref(false);
const editSpinner = ref(new Map<string, boolean>());
const deleteSpinner = ref(new Map<string, boolean>());

onBeforeMount(() =>
{

  stations.load();
  teams.load();

});

const isIn = function(team: Team, station: Station): boolean
{

  if (typeof station.results === "undefined") {
    return false;
  }

  if (station.results?.length === 0) {
    return false;
  }

  const result = station.results?.filter((result) => {
    return result.team_id === team.id;
  });

  if (typeof result === "undefined") {
    return false;
  }

  return result.length > 0;

}


const showAddStation = function(): void
{

  console.log( 123 );

}


const showTeam = function(team: Team, station: Station): void
{

}

</script>