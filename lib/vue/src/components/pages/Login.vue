<template>
  <main>
    <div id="login" class="block">
      <div id="logo"></div>
      <form method="post" id="login-body" @submit.prevent="send_login">
        <InputText v-model="login" name="login" placeholder="Benutzername" icon="person-fill" vertical />
        <InputText v-model="password" value="sonne21" name="password" type="password" placeholder="Password" icon="key-fill"  vertical />
        <Submit name="send_login" standalone>Anmelden</Submit>
      </form>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { AuthStore } from "../../lib/store/auth";
import { useRouter } from "vue-router";

import InputText from "../elements/form/InputText.vue";
import Submit from "../elements/form/Submit.vue";

const login = ref('Yooko');
const password = ref('sonne21');
const auth = AuthStore();
const router = useRouter();

const send_login = async function() {

  auth.login(login.value, password.value)
    .then(() => {
      router.push({ name: 'dashboard' });
    });

}

</script>

<style scoped>
@import "../../assets/css/login.css";
</style>