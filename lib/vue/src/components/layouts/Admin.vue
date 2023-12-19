<template>
  <div id="admin" :class="{'nav_sm': small}">
    <Navigation></Navigation>
    <div id="header">
        <div class="nav_controller" @click="transformNavigation"><i /><i /><i /></div>
        <div class="logged_in">
            <div class="avatar"><Icon name="person-fill" class="alone" /></div>
            <div class="user">Eingeloggt: Yooko</div>
        </div>
    </div>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script setup lang="ts">

import { onBeforeMount, ref } from "vue";
import { AuthStore } from "../../lib/store/auth";

import Navigation from "../Navigation.vue";

const small = ref(false);
const auth = AuthStore();

onBeforeMount(() => {
    small.value = auth.data.small_navigation ?? false;
});

const transformNavigation = function()
{

    small.value = !small.value;
    auth.setUserData({small_navigation: small.value});

}

</script>