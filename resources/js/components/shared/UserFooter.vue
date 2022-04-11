<template>
  <div class="black py-10">
    <v-container>
      <v-row>
        <v-col cols="12" sm="9">
          <v-row>
            <v-col cols="12" sm="3">
              <div class="white--text font-weight-bold">Company</div>
              <ul class="d-flex flex-col pa-0 mt-5">
                <li class="mb-2">
                  <router-link class="white--text" to="/">About Us</router-link>
                </li>
                <li class="mb-2">
                  <router-link class="white--text" to="/">Terms of Service</router-link>
                </li>
              </ul>
            </v-col>
            <v-col cols="12" sm="3">
              <div class="white--text font-weight-bold">Top Categories</div>
              <ul class="d-flex flex-col pa-0 mt-5">
                <li class="mb-2" v-for="category in categories" :key="category.id">
                  <router-link class="white--text" to="/">{{category.name}}</router-link>
                </li>
              </ul>
            </v-col>
            <v-col cols="12" sm="3">
              <div class="white--text font-weight-bold">Customer Care</div>
              <ul class="d-flex flex-col pa-0 mt-5">
                <li class="mb-2">
                  <router-link class="white--text" to="/">Contact Us</router-link>
                </li>
                <li class="mb-2">
                  <router-link class="white--text" to="/">Terms and Conditions</router-link>
                </li>
                <li class="mb-2">
                  <router-link class="white--text" to="/">Privacy</router-link>
                </li>
                <li class="mb-2">
                  <router-link class="white--text" to="/">Consignor Terms</router-link>
                </li>
              </ul>
            </v-col>
            <v-col cols="12" sm="3">
              <div class="white--text font-weight-bold">Payment Method</div>
              <div class="d-flex justify-space-between mt-5">
                <img style="max-width: 30%" src="/images/ATM_Bersama_2016.png" alt="ATM Bersama Logo">
                <img style="max-width: 30%" src="/images/mc_symbol.svg" alt="Mastercard Logo">
                <img style="max-width: 30%" src="/images/Visa_2021.svg" alt="Visa Logo">
              </div>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" sm="3" class="d-flex flex-col white--text text-center">
          <h2 class="text-3xl font-weight-black">ASLISEMUA</h2>
          <div class="mx-auto mt-5">
            <v-icon color="white">mdi-facebook</v-icon>
            <v-icon color="white">mdi-instagram</v-icon>
            <v-icon color="white">mdi-linkedin</v-icon>
          </div>
          <p class="mt-5">&copy; 2021 Aslisemua</p>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">

        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  name: "UserFooter",
  data: function () {
    return {
      categories: []
    }
  },
  created () {
    this.getCategories()
  },
  methods: {
    getCategories () {
      return this.$axios.get(`/api/v1/categories/public/main?limit=0`).then(response => {
        if (response.status === 200){
          this.categories = response.data.data.filter(item => item.parent === null || item.parent === 'null')
        }
      }).catch(error => {
        let message = ''
        if (error.response) message = error.response.data.message
        else if (error.request) message = 'Something went wrong, please contact admin'
        else message = error.message
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: message,
          type: 'error'
        })
      })
    },
  }
}
</script>

<style scoped>

</style>
