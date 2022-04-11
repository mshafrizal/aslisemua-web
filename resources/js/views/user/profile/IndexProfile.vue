<template>
  <v-container>
    <v-row class="mt-5">
      <v-col cols="12">
        <h1 class="text-5xl">Hello, {{ username }}</h1>
      </v-col>
      <v-col cols="12">
        <v-divider />
      </v-col>
    </v-row>
    <v-row class="mt-5">
      <v-col cols="12">
        <v-tabs :vertical="viewport === 'xs' ? false : true" show-arrows>
          <v-tab class="justify-start">
            <v-icon left>
              mdi-account
            </v-icon>
            <span>
              Personal Info
            </span>
          </v-tab>
          <v-tab class="justify-start">
            <v-icon left>
              mdi-receipt
            </v-icon>
            <span>
              My Purchases
            </span>
          </v-tab>
          <v-tab class="justify-start">
            <v-icon left>
              mdi-truck-outline
            </v-icon>
            <span>
              Track Shipment
            </span>
          </v-tab>
          <v-tab class="justify-start">
            <v-icon left>
              mdi-google-maps
            </v-icon>
            <span>
              Address
            </span>
          </v-tab>

          <v-tab-item>
            <personal-info />
          </v-tab-item>
          <v-tab-item>
            <my-purchases />
          </v-tab-item>
          <v-tab-item>
<!--            <TrackShipment />-->
          </v-tab-item>
          <v-tab-item>
            <my-addresses />
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PersonalInfo from "./PersonalInfo";
import MyPurchases from "./MyPurchases";
import MyAddresses from "./MyAddresses";
// import TrackShipment from "./TrackShipment";
export default {
  name: "IndexProfile",
  components: {MyAddresses, MyPurchases, PersonalInfo},
  data: function () {
    return {
      address: null,
      loadingAddress: false,
      loadingMyPurchases: false,
      loadingShipment: false,
      personalInfo: null,
      myPurchases: null,
      shipment: null,
    }
  },
  
  methods:{
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
