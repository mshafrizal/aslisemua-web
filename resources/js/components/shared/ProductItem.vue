<template>
  <div class="product">
    <img src="/images/product-1.jpg" alt="" class="product__img">
    <div class="product__info">
      <h1 class="text-uppercase font-weight-bold text-lg black--text">NIKE</h1>
      <p class="black--text mt-0 mb-1">Air Jordan</p>
      <p class="black--text mt-0 mb-1">Size: 42</p>
      <p class="text-yellow-500 mt-0 mb-1">Rp 3.250.000</p>
    </div>
  </div>
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
  mounted() {
    // console.log(this.product)
  }
}
</script>

<style scoped>

</style>
