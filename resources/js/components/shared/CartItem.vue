<template>
  <v-card class="mb-4">
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="3">
          <v-img :src="product.image_path"></v-img>
        </v-col>
        <v-col cols="12" sm="8">
          <h1 class="text-xl font-weight-bold mb-3" v-if="!brand.loading">{{ brand.data.name }}</h1>
          <p class="mb-1">{{ product.name }}</p>
          <p class="mb-1">Size: {{ product.size }}</p>
          <p class="mb-1">Rp {{ product.final_price.toLocaleString() }}</p>
        </v-col>
        <v-col cols="12" sm="1">
          <v-btn @click="remove" icon><v-icon>mdi-close</v-icon></v-btn>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'CartItem',
  props: ['product'],
  data: function () {
    return {
      brand: {
        data: null,
        loading: true
      }
    }
  },
  mounted () {
    this.getBrand(this.product.brand_id)
  },
  methods: {
    remove () {
      console.log('remove')
      this.$emit('remove', this.product.id)
    },
    getBrand (brand_id) {
      this.brand.loading = true
      this.$store.dispatch('brand/fetchBrand', { brand_id: brand_id }).then(result => {
        this.brand.data = result.results
      }).finally(() => this.brand.loading = false)
    }
  }
}
</script>

<style>

</style>