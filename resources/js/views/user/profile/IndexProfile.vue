<template>
  <v-container>
    <v-row class="mt-5">
      <v-col cols="12">
        <h1 class="text-5xl text-center">Hello, {{ username }}</h1>
      </v-col>
    </v-row>
    <v-row class="mt-5" justify="center">
      <v-col cols="12" md="8">
          <v-row dense>
            <v-col cols="12" sm="3">
              <v-btn to="/profile/detail" color="black" outlined exact-path block>
                <v-icon left>mdi-account</v-icon>
                PERSONAL INFO
              </v-btn>
            </v-col>
            <v-col cols="12" sm="3">
              <v-btn to="/profile/transaction" color="black" outlined exact-path block>
                <v-icon left>mdi-receipt</v-icon>
                MY PURCHASES
              </v-btn>
            </v-col>
            <v-col cols="12" sm="3">
              <v-btn to="/profile/shipment" color="black" outlined exact-path block>
                <v-icon left>mdi-truck</v-icon>
                SHIPMENT
              </v-btn>
            </v-col>
            <v-col cols="12" sm="3">
              <v-btn to="/profile/my-address" color="black" outlined exact-path block>
                <v-icon left>mdi-map-marker</v-icon>
                MY ADDRESSES
              </v-btn>
            </v-col>
          </v-row>
      </v-col>
      <v-col cols="12">
          <router-view :key="$route.fullPath">
          </router-view>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "IndexProfile",
  data: function () {
    return {
      activeTab: 0,
    }
  },
  computed: {
    viewport () {
      return this.$vuetify.breakpoint.name
    },
    username () {
      const user = JSON.parse(window.localStorage.getItem('user'))
      console.log(user)
      if (user) return user.name
      else return '-'
    }
  }
}
</script>

<style scoped>

</style>
