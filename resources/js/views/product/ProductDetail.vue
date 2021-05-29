<template>
  <v-row>
    <v-col cols="12" sm="10"><h2>Product List</h2></v-col>
    <v-col cols="12" sm="2">
      <v-btn href="/admin/product/:id/edit" block>Edit Product</v-btn>
    </v-col>
    <v-col cols="12">
      <v-card class="text-caption">
        <v-container fluid>
          <v-row>
            <v-col cols="12" sm="3">
              <v-img
                v-if="product"
                :lazy-src="'/storage/'+product.product_image[0].image_path"
                max-height="150"
                max-width="250"
                :src="'/storage/'+product.product_image[0].image_path"
              />
            </v-col>
            <v-col cols="12" sm="9">
              <h3 class="text-h4">{{ product ? product.name : '' }}</h3>
              <v-row>
                <v-col cols="12" sm="6">
                  <v-row dense>
                    <v-col class="grey--text text--lighten-1" cols="4">Brand</v-col>
                    <v-col cols="8">{{product ? product.brand.name : ''}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Size</v-col>
                    <v-col cols="8">{{product ? product.size : ''}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Price</v-col>
                    <v-col cols="8">{{product ? 'Rp '.concat(product.base_price.toLocaleString('id')) : ''}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Discount</v-col>
                    <v-col cols="8">{{product ? 'Rp '.concat(product.discount_price.toLocaleString('id')) : 0}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Final Price</v-col>
                    <v-col cols="8">{{product ? 'Rp '.concat(product.final_price.toLocaleString('id')) : 0}}</v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-row dense>
                    <v-col class="grey--text text--lighten-1" cols="4">Category</v-col>
                    <v-col cols="8">{{product ? product.category.name : ''}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Status</v-col>
                    <v-col cols="8" :class="product && product.status === 1 ? 'primary--text' : 'yellow--text'">{{product && product.status === 1 ? 'Published' : 'Not Published'}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Price</v-col>
                    <v-col cols="8">{{product ? product.base_price : ''}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Stock Status</v-col>
                    <v-col cols="8">{{product && product.stock > 0 ? 'In Stock' : 'Out of Stock'}}</v-col>

                    <v-col class="grey--text text--lighten-1" cols="4">Created By</v-col>
                    <v-col cols="8">{{product ? product.created_by : 0}}</v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-col>
    <v-col cols="12" sm="6">
      <v-card>
        <v-card-title>Pictures</v-card-title>
        <v-divider />
        <v-card-text v-if="product">
          <v-container fluid>
            <v-row>
              <v-col cols="6" sm="4" v-for="image in product.product_image">
                <v-img
                  :key="image.id"
                  :lazy-src="'/storage/'+image.image_path"
                  max-height="150"
                  max-width="250"
                  contain
                  :src="'/storage/'+image.image_path"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" depressed><v-icon left>mdi-plus</v-icon>Upload More</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col cols="12" sm="6">
      <v-row>
        <v-col cols="12">
          <v-card v-if="product">
            <v-card-title>Details</v-card-title>
            <v-divider />
            <v-card-text>
              <span v-html="product.detail"></span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card v-if="product">
            <v-card-title>Description</v-card-title>
            <v-divider />
            <v-card-text>
              <span v-html="product.description"></span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "ProductDetail",
  data: function () {
    return {
      loading: false,
      product: null
    }
  },
  created () {
    this.fetchProduct()
  },
  methods: {
    fetchProduct () {
      this.loading = true
      const params = {
        product_id: this.$route.params.id
      }
      this.$store.dispatch('product/adminFetchProduct', params).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.product = result.results.data
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error || error.toString()
        })
      }).finally(() => this.loading = false)
    }
  }
}
</script>

<style scoped>

</style>
