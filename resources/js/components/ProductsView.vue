<template>
  <div class="sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
    <div>{{url}}</div>
    <div>{{query}}</div>
<!--    <div>{{window.location.href}}</div>-->
  </div>
</template>

<script>
export default {
  name: "ProductsView",
  props: {
    currentUrl: {
      type: String,
      required: false
    }
  },
  data: function () {
    return {
      query: '',
      url: window.location.hash,
      params: null
    }
  },
  mounted () {
    this.query = new URLSearchParams(this.url)
    this.params = Object.fromEntries(this.query.entries())
  }
}
</script>

<style scoped>

</style>
