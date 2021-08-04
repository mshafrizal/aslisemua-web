<template>
  <v-container>
    <v-row class="mt-5">
      <v-col cols="12">
        <h1 class="text-5xl">Hello, Jonathan Morningstar</h1>
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
            <v-card flat>
              <v-card-text>
                <p>
                  Fusce a quam. Phasellus nec sem in justo pellentesque facilisis. Nam eget dui. Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. In dui magna, posuere eget, vestibulum et, tempor auctor, justo.
                </p>

                <p class="mb-0">
                  Cras sagittis. Phasellus nec sem in justo pellentesque facilisis. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nam at tortor in tellus interdum sagittis.
                </p>
              </v-card-text>
            </v-card>
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PersonalInfo from "./PersonalInfo";
import MyPurchases from "./MyPurchases";
export default {
  name: "IndexProfile",
  components: {MyPurchases, PersonalInfo},
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
  created () {
  },
  methods:{
  },
  computed: {
    viewport () {
      return this.$vuetify.breakpoint.name
    }
  }
}
</script>

<style scoped>

</style>
