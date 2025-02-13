<script setup>
import { RouterView } from 'vue-router';
</script>

<template>
  <header>
    <Menubar class="navbar">
      <template #start>
        <Button label="Home" icon="pi pi-home" @click="$router.push('/')" class="p-button-text" />
        <Button label="Creation Besoins" icon="pi pi-plus" @click="$router.push('/besoins')" class="p-button-text" />
        <Button label="Gestion Salaries" icon="pi pi-users" @click="$router.push('/gestion-salaries')" class="p-button-text" />
        <Button label="Liste Besoins" icon="pi pi-list" @click="$router.push('/besoins/liste')" class="p-button-text" />
      </template>
      <template #end>
        <Button label="Se déconnecter" icon="pi pi-sign-out" class="p-button-text colorBlueAkt" @click="$router.push('/login')" />
      </template>
    </Menubar>
  </header>

  <RouterView />
</template>