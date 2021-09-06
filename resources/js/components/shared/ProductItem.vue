<template>
  <router-link :to="`/product/${product.slug}`" class="product" v-if="product && product.products_images.length > 0">
    <img :src="product.products_images[0].image_path" alt="" class="product__img">
    <div class="product__info">
      <h1 class="text-uppercase font-weight-bold text-lg black--text">{{product.brand.name}}</h1>
      <p class="black--text mt-0 mb-1">{{product.name}}</p>
      <p class="black--text mt-0 mb-1">Size: {{product.size || '-'}}</p>
      <p class="text-yellow-500 mt-0 mb-1">Rp {{product.final_price.toLocaleString()}}</p>
    </div>
  </router-link>
</template>

<script>
export default {
  name: "ProductItem",
  props: {
    product: {
      type: Object,
      default: null,
      required: true
    }
  },
}
</script>

<style scoped>

.product {
  display: flex;
  flex-direction: column;
}
.product:hover {
  cursor: pointer
}
.product__img {
  aspect-ratio: 2/3;
  /*width: 100%;*/
  height: auto;
  object-fit: cover;
}
.product__info {
  margin-top: 16px;
  text-align: center;
}
</style>
