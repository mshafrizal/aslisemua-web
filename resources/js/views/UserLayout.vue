<template>
  <v-app id="user">
    <v-snackbar top v-if="snackbar" v-model="snackbar.value" :color="snackbar.type">
      {{snackbar ? snackbar.message : '-'}}
    </v-snackbar>
    <user-navigation />
    <v-divider />
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import UserNavigation from "../components/shared/UserNavigation";
export default {
  name: "UserLayout",
  components: {UserNavigation},
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
</style>
