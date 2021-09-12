<template>
  <v-card class="relative h-full product-card">
    <v-img height="250" :src="product.products_images[0].image_path"></v-img>
    <v-card-text class="d-flex flex-column justify-center text-center">
      <p class="font-weight-bold mb-3 black--text text-lg">{{ product.brand.name }}</p>
      <p class="mb-2">{{ product.name }}</p>
      <p v-if="product.size" class="mb-2">Size: {{ product.size }}</p>
      <p class="warning--text mb-2">Rp {{ product.base_price.toLocaleString() }}</p>
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

<style scoped>
  .product-card:hover {
    cursor: pointer;
  }
</style>
