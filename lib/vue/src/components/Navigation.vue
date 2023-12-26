<template>
  <aside id="sidebar">
    <div id="logo"></div>
    <nav id="main">
      <ul>
          <li v-for="item in menu"><router-link :to="{ name: item.name }"><Icon :name="item.icon" :class="item.css" /><span>{{ item.value }}</span></router-link></li>
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

interface MenuItem {

  name: string,
  icon: string,
  css: string
  value: string

}


const menu: Array<MenuItem> = [

  {name: 'dashboard', icon: 'grid-1x2-fill', css: 'before', value: 'Dashboard'},
  {name: 'teams', icon: 'people-fill', css: 'before', value: 'Teams'},
  {name: 'stations', icon: 'geo-alt-fill', css: 'before', value: 'Stationen'},
  {name: 'referees', icon: 'person-fill', css: 'before', value: 'Kampfrichter'},
  {name: 'result', icon: 'clipboard2-fill', css: 'before', value: 'Ergebnisse'},
  {name: 'evaluation', icon: 'bar-chart-fill', css: 'before', value: 'Auswertung'},

];


const footer: Array<MenuItem> = [

  {name: 'settings', icon: 'gear-fill', css: 'alone', value: 'Einstellungen'},
  {name: 'admin-settings', icon: 'shield-lock-fill', css: 'alone', value: 'Admin-Einstellungen'},
  {name: 'logout', icon: 'power', css: 'alone', value: 'Abmelden'},

];

</script>