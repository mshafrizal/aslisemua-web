<template>
  <v-row>
    <v-col cols="12">Create Product</v-col>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6">
              <v-row>
                <v-col cols="12"><h2>Product Information</h2></v-col>
                <v-divider/>

                <v-col cols="12" sm="9">
                  <v-text-field id="product_name" v-model="formCreateProduct.name" label="Product Name" outlined dense></v-text-field>
                </v-col>

                <v-col cols="12" sm="9">
                  <v-select id="brand" v-model="formCreateProduct.brand_id" :items="brands" outlined dense item-text="name" item-value="id"></v-select>
                </v-col>

              </v-row>
            </v-col>
            <v-col cols="12" sm="6"></v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "ProductCreate",
  data: function () {
    return {
      brands: [],
      categories: [],
      dialogConfirmation: false,
      formCreateProduct: {
        name: '',
        brand_id: '',
        category_id: '',
        size: '',
        gender: '',
        color: '',
        condition: '',
        description: '',
        detail: '',
        discount_price: 0,
        alt_image: '',
        base_price: 0,
        final_price: 0,
        images: []
      },
      loading: false,
      valid: true
    }
  },
  created () {
    this.fetchBrands()
    this.fetchCategories()
  },
  methods: {
    async fetchBrands () {
      this.loading = true
      this.$store.dispatch('brand/fetchBrands').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.brands = result.results.data
          return true
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: error,
          type: 'error'
        })
        return false
      }).finally(() => this.loading = false)
    },
    async fetchCategories () {
      this.loading = true
      this.$store.dispatch('category/adminFetchCategories').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.categories = result.data
          return true
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: error,
          type: 'error'
        })
        return false
      }).finally(() => this.loading = false)
    }
  }
}
</script>

<style scoped>

</style>
