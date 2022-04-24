<template>
  <v-app id="user">
    <v-snackbar-queue
      :items="snackbarItems"
      @remove="removeItem"
      close-button-icon="mdi-close"
      top
      next-button-count-text="More"></v-snackbar-queue>
    <user-navigation />
    <v-divider />
    <v-main>
      <router-view :key="$route.fullPath" />
    </v-main>

    <v-row class="border border-black border-b">
      <v-col cols="12">
        <v-container>
          <v-row no-gutters>
            <v-col cols="12" sm="6">
              <v-sheet class="d-flex flex-column text-center">
                <h2 class="text-2xl mb-2">Consign With Us</h2>
                <p>Receive up to 75% each item's sale price</p>
                <div>
                  <v-btn class="mt-10" color="black" outlined>Consign</v-btn>
                </div>
              </v-sheet>
            </v-col>
            <v-col cols="12" sm="6">
              <v-sheet class="d-flex flex-column text-center">
                <h2 class="text-2xl mb-2">Got Questions?</h2>
                <p>Email us at:</p>
                <div>
                  <v-btn class="mt-10 text-lowercase" color="brown" text>admin@aslisemua.com</v-btn>
                </div>
              </v-sheet>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <user-footer />
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import UserNavigation from "../components/shared/UserNavigation";
import UserFooter from "../components/shared/UserFooter";
export default {
  name: "UserLayout",
  components: {UserFooter, UserNavigation},
  computed: {
    ...mapGetters([
      'getSnackbar'
    ]),
    snackbarItems () {
      return this.$store.getters.getSnackbar
    }
  },
  methods: {
    removeItem (id) {
      this.$store.dispatch('removeSnackbarMessage', id)
    }
  }
}
</script>

<style scoped>
</style>
