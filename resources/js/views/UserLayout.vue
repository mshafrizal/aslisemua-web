<template>
  <v-app id="user">
    <v-snackbar top v-if="snackbar" v-model="snackbar.value" :color="snackbar.type">
      {{snackbar ? snackbar.message : '-'}}
    </v-snackbar>

    <v-container v-if="$route.meta.navbar">
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
import { mapGetters } from 'vuex'
export default {
  name: "UserLayout",
  computed: {
    ...mapGetters([
      'getSnackbar'
    ]),
    snackbar () {
      return this.$store.getters.getSnackbar
    }
  }
}
</script>

<style scoped>
  .logo {
    font-size: 2.5rem;
  }
</style>
