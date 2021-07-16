<template>
  <v-app id="user">
    <v-container>
      <v-row>
        <v-col></v-col>
        <v-col>
          <h1 class="text-center logo">ASLISEMUA</h1>
        </v-col>
        <v-col class="d-flex justify-end">
          <v-btn icon><v-icon>mdi-heart-outline</v-icon></v-btn>
          <v-btn icon><v-icon>mdi-cart-outline</v-icon></v-btn>
          <v-btn icon><v-icon>mdi-account-outline</v-icon></v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "UserLayout"
}
</script>

<style scoped>
  .logo {
    font-size: 2.5rem;
  }
</style>
