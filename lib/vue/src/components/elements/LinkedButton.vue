<template>
  <router-link to="{{ to }}" class="linked-button"><slot /></router-link>
</template>

<script setup lang="ts">
</script>

<style scoped>
.linked-button {
  padding: 8px;
  margin-right: 5px;

  border-radius: 3px;
  display: inline-block;
  background-color: rgba(var(--highlight), .9);

  font-size: .95rem;
  line-height: .95rem;
  text-decoration: none;
  color: rgb(var(--white));
}

.red {
  background-color: rgba(var(--red), .9);
}

.linked-button >>> i {
  margin-right: 5px;
}
</style>