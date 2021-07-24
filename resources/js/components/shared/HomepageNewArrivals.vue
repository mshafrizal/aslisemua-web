<template>
  <section>
    <h1 class="text-3xl text-center mt-20">NEW ARRIVALS</h1>

    <v-window show-arrows>

    </v-window>
  </section>
</template>

<script>
export default {
  name: "HomepageNewArrivals",
  data: function () {
    return {
      products: []
    }
  },
  created () {
    this.getProducts()
  },
  methods: {
    getProducts () {
      this.$axios.get(`${process.env.MIX_APP_URL}/api/v1/products/public/main?limit=2&sale=no&new_arrival=yes`).then(response => {
        console.log('getproducts', response)
      }).catch(error => {
        console.log(error)
      })

    }
  }
}
</script>

<style scoped>

</style>
