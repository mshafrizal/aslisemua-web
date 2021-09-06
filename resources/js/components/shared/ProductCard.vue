<template>
  <v-card class="relative">
    <v-img :src="product.image_path"></v-img>
    <v-card-text class="d-flex justify-center text-center">
      <p class="font-weight-bold mb-3">{{ product.brand.name }}</p>
      <p class="font-weight-bold mb-2">{{ product.name }}</p>
      <p class="font-weight-bold mb-2">Size: {{ product.size }}</p>
      <p class="warning mb-2">Rp {{ product.base_price.toLocaleString() }}</p>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'ProductCard',
  props: ['product'],
  data: function () {
    return {
      wishlist: {
        success: false,
        loading: false,
        value: false
      }
    }
  },
  methods: {
    addToWishlist () {
      console.log('to wishlist')
    }
  }  
}
</script>

<style>

</style>