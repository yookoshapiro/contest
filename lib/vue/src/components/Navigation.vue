<template>
  <aside id="sidebar">
    <div id="logo"></div>
    <nav id="main">
      <ul>
        <li><router-link :to="{ name: 'showDashboard' }" class="icon icon-dashboard">Dashboard</router-link></li>
        <li><router-link :to="{ name: 'showUsers' }" class="icon icon-perm-identity">Benutzer</router-link></li>
        <li><router-link :to="{ name: 'showTeams' }" class="icon icon-people">Teams</router-link></li>
        <li><router-link :to="{ name: 'showStations' }" class="icon icon-location">Stationen</router-link></li>
        <li><router-link :to="{ name: 'showResults' }" class="icon icon-star">Ergebnisse</router-link></li>
        <li><router-link :to="{ name: 'showEvaluation' }" class="icon icon-view-list">Auswertung</router-link></li>
      </ul>
    </nav>
    <div id="sidebar-footer">
      <ul>
        <li><router-link :to="{ name: 'showSettings' }"><i class="icon icon-settings" title="Einstellungen"></i></router-link></li>
        <li><router-link :to="{ name: 'showAdminSettings' }"><i class="icon icon-admin-panel-settings" title="Admin-Einstellungen"></i></router-link></li>
        <li><router-link :to="{ name: 'showLogin' }"><i class="icon icon-power-setting" title="Abmelden"></i></router-link></li>
      </ul>
    </div>
  </aside>
</template>