<template>
  <v-badge 
    color="black"
    overlap
  >
    <template v-if="products.length > 0" v-slot:badge>
      {{ products.length }}
    </template>
    <v-btn @click="toCartPage" icon><v-icon>mdi-cart-outline</v-icon></v-btn>
  </v-badge>
  
</template>

<script>
export default {
  name: 'CartButton',
  data: function () {
    return {
      products: []
    }
  },
  created () {
    this.getProducts()
  },
  methods: {
    toCartPage () {
      this.$router.push('/cart').catch(() => {})
    },
    getProducts () {
      this.$store.dispatch('cart/getProducts').then(result => {
        this.products = result.data
      })
    }
  }
}
</script>

<style>

</style>