<template>
  <aside id="sidebar">
    <div id="logo"></div>
    <nav id="main">
      <ul>
        <li v-for="item in menu"><router-link :to="{ name: item.name }"><Icon :name="item.icon" :class="item.css" />{{ item.value }}</router-link></li>
      </ul>
    </nav>
    <div id="sidebar-footer">
      <ul>
        <li v-for="item in footer"><router-link :to="{ name: item.name }"><Icon :name="item.icon" :class="item.css" />{{ item.value }}</router-link></li>
      </ul>
    </div>
  </aside>
</template>

<script setup lang="ts">

import Icon from "./elements/Icon.vue";
import {ref} from "vue";

interface MenuItem {

  name: string,
  icon: string,
  css: string
  value: string


}

const menu: Array<MenuItem> = [
  {name: 'showDashboard', icon: 'grid-1x2-fill', css: 'before', value: 'Dashboard'},
  {name: 'showUsers', icon: 'person-fill', css: 'before', value: 'Benutzer'},
  {name: 'showTeams', icon: 'people-fill', css: 'before', value: 'Teams'},
  {name: 'showStations', icon: 'geo-alt-fill', css: 'before', value: 'Stationen'},
  {name: 'showResults', icon: 'clipboard2-fill', css: 'before', value: 'Ergebnisse'},
  {name: 'showEvaluation', icon: 'bar-chart-fill', css: 'before', value: 'Auswertung'},
];

const footer: Array<MenuItem> = [
  {name: 'showSettings', icon: 'gear-fill', css: 'alone', value: 'Einstellungen'},
  {name: 'showAdminSettings', icon: 'shield-lock-fill', css: 'alone', value: 'Admin-Einstellungen'},
  {name: 'showLogin', icon: 'power', css: 'alone', value: 'Abmelden'},
];

</script>