<template>
  <router-view></router-view>
  <Notifications />
  <Alert />
</template>

<script setup lang="ts">
import { onBeforeMount } from "vue";
import { AuthStore } from "./lib/store/auth";
import { useRouter } from "vue-router";

const auth = AuthStore()
const router = useRouter();

onBeforeMount(async () =>
{

  await auth.validate()
      .catch((error) => {
        if( error?.response?.status === 401 ) {
          router.replace({name: 'login'});
        }
      });

});

</script>