<template>
  <v-container class="mb-10">
    <v-row>
      <v-col cols="12">
        <h1 class="text-4xl my-5 text-center text-uppercase">New Arrivals</h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="3">
        <v-card outlined class="relative">
          <v-card-text>
            <div class="text-lg font-weight-bold">Categories</div>
            <v-treeview
              activatable
              dense
              return-object
              :items="computedCategories"
              @update:active="selectCategory"
            ></v-treeview>
          </v-card-text>
          <v-divider />
          <v-card-text>
            <div class="text-lg font-weight-bold">Price Range</div>
            <v-text-field
              v-model="start_price"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="From"
              class="mt-2"
              @blur="getProducts"
            />
            <v-text-field
              v-model="end_price"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="To"
              class="mt-4"
              @blur="getProducts"
            />
          </v-card-text>
          <v-divider />
          <v-card-text>
            <div class="text-lg font-weight-bold mb-2">Brands</div>
            <div class="d-flex flex-col">
              <template v-for="brand in brands">
                <v-checkbox
                  v-model="selectedBrand"
                  :key="brand.id"
                  :label="brand.name"
                  hide-details
                  :value="brand.name"
                  dense
                  color="black"
                  @change="getProducts"
                />
              </template>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="9" class="relative">
        <v-row>
          <v-col cols="12" offset-sm="7" sm="5">
            <v-toolbar flat>
              <div>Sort by</div>
              <v-select
                :items="orderByOptions"
                item-key="value"
                item-text="text"
                v-model="orderBy"
                outlined
                dense
                single-line
                hide-details
                class="ml-2"
                @change="getProducts"
              />
            </v-toolbar>
          </v-col>
        </v-row>
<!--        <v-row>-->
<!--          <v-col cols="12" sm="3">-->
<!--            <v-select-->
<!--              v-model=""-->
<!--            />-->
<!--          </v-col>-->
<!--          <v-col cols="12" sm="3"></v-col>-->
<!--        </v-row>-->
        <div v-if="loading" class="loading-progress h-full d-flex items-center justify-center">
          <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <v-row v-else>
          <template v-for="product in products.data">
            <v-col cols="6" sm="4" md="3">
              <product-item :product="product" :key="product.id"/>
            </v-col>
          </template>
        </v-row>
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between">
            <v-btn icon outlined color="black" :disabled="page === 1">
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn icon outlined color="black" :disabled="noMoreData">
              <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ProductItem from "../../../components/shared/ProductItem";
export default {
  name: "NewArrivals",
  components: {ProductItem},
  data: function () {
    return {
      categories: null,
      colorOptions: [],
      color: '',
      brands: [],
      keyword: '',
      loading: true,
      orderBy: '',
      orderByOptions: [
        { text: 'Newest First', value: '' },
        { text: 'Price: Low - High', value: 'asc' },
        { text: 'Price: High - Low', value: 'desc' }
      ],
      page: 1,
      products: null,
      selectedBrand: [],
      selectedCategory: null,
      selectedParent: null,
      sizeOptions: [],
      size: '',
      start_price: '',
      end_price: ''
    }
  },
  beforeMount() {
    this.getCategories()
    this.getBrands()
    this.getProducts ()
  },
  methods: {
    getProducts () {
      this.loading = true
      let query = []
      if (this.selectedBrand.length > 0) query.push(`brand=${this.selectedBrand.toString()}`)

      if (this.selectedCategory) query.push(`category=${this.selectedCategory}`)

      if (this.orderBy) query.push(`order_by=${this.orderBy}`)

      if (this.start_price) query.push(`start_price=${this.start_price}`)

      if (this.end_price) query.push(`end_price=${this.end_price}`)

      if (this.keyword) query.push(`keywords=${this.keyword}`)
      // query.push(`new_arrival=yes&sale=no`)

      query = query.join('&')

      this.$axios.get(`/api/v1/products/public/main?${query}`).then(response => {
        if (response.status === 200) {
          console.log(response)
          this.products = response.data
        }
      }).catch(error => {
        let message
        if (error.response) message = error.response.data.message
        else if (error.request) message = error.message
        else message = error.message.toString()
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: message,
          type: 'error'
        })
      }).finally(() => this.loading = false)
    },
    getCategories () {
      this.$store.dispatch('category/fetchCategories', 'main?limit=0').then(result => {
        if (result.status === 200) {
          this.categories = result
        } else {
          console.log(result)
        }
      })
    },
    getBrands () {
      this.$store.dispatch('brand/fetchBrandsPublic').then(response => {
        if (response.status === 200) {
          this.brands = response.results
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: error.message.toString(),
          type: 'error'
        })
      })
    },
    selectCategory (cat) {
      console.log(cat)
      this.selectedCategory = cat[0].name
      this.getProducts()
    },
    setSelectedParent (cat) {
      this.selectedParent = cat
    }
  },
  computed: {
    computedCategories () {
      if (this.categories) {
        const parent = this.categories.data.filter(category => category.parent === 'null' || !category.parent)
        parent.forEach(category => {
          category.children = this.categories.data.filter(sub => sub.parent === category.id)
        })
        return parent
      }
      return []
    },
    noMoreData () {
      if (this.products) {
        if (!this.products.links.next) return true
        else return false
      }
    }
  }
}
</script>

<style scoped>

</style>
