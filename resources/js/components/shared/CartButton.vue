<template>
  <v-badge 
    v-if="products.length > 0" 
    color="black"
    overlap
  >
    <template v-slot:badge>
      {{ products.length }}
    </template>
    <v-btn @click="toCartPage" icon><v-icon>mdi-cart-outline</v-icon></v-btn>
  </v-badge>
  <v-btn v-else @click="toCartPage" icon><v-icon>mdi-cart-outline</v-icon></v-btn>
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
      if (window.localStorage.getItem('token')) {
        this.$store.dispatch('cart/getProducts').then(result => {
          this.products = result.data
        })
      }
    }
  }
}
</script>

<style>

</style>