<template>
  <v-app :theme="dark ? 'dark' : 'light'">
    <v-layout class="rounded rounded-md">
      <v-app-bar>
        <v-toolbar-title>
          <div class="d-flex align-center font-weight-bold" :class="{ 'text-white': dark }">
            <v-icon 
              class="mr-2"
              style="font-size:32px;"
              icon="mdi-airplane"
            /> Onfly
          </div>
        </v-toolbar-title>

        <v-btn class="px-1" min-width="0px" icon :color="dark ? 'blue' : 'dark'" @click="switchTheme()">
          <v-icon>mdi-theme-light-dark</v-icon>
        </v-btn>

        <v-btn class="px-1" min-width="0px" icon :color="dark ? 'blue' : 'dark'" @click="logout()">
          <v-icon>mdi-logout</v-icon>
        </v-btn>
      </v-app-bar>

      <v-main class="d-flex align-center justify-center" style="height: 100vh;">
        <slot />
      </v-main>
    </v-layout>
  </v-app>
</template>

<script setup>
definePageMeta({
  middleware: ['auth']
});
</script>

<script>
import ChangeTheme from '@/mixins/ChangeTheme.vue'
import Logout from '@/mixins/Logout.vue'

export default {
  mixins: [ChangeTheme, Logout],
} 
</script>