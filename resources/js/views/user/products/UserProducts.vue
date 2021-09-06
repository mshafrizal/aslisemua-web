<template>
  <v-container class="mb-10">
    <pre>{{JSON.stringify(this.$route.params, null, 2)}}</pre>
    <v-row class="mt-5 mb-5">
      <v-col cols="12" class="text-center">
        <h1 class="text-3xl">{{ this.$route.params.category_name }}</h1>
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
              :items="categories.data"
              @update:active="categories.selected"
            ></v-treeview>
          </v-card-text>
          <v-divider />
          <v-card-text>
            <div class="text-lg font-weight-bold">Price Range</div>
            <v-text-field
              v-model="price.start"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="From"
              class="mt-2"
              @blur="fetchProducts"
            />
            <v-text-field
              v-model="price.end"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="To"
              class="mt-4"
              @blur="fetchProducts"
            />
          </v-card-text>
          <v-divider />
          <v-card-text>
            <div class="text-lg font-weight-bold mb-2">Brands</div>
            <div class="d-flex flex-col">
              <template v-for="brand in brands.data">
                <v-checkbox
                  v-model="brands.selected"
                  :key="brand.id"
                  :label="brand.name"
                  hide-details
                  :value="brand.name"
                  dense
                  color="black"
                  @change="fetchProducts"
                />
              </template>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="9">
        <v-row>
          <template v-if="products.loading">
            <v-col cols="6" sm="3" v-for="i in 4" :key="i">
              <v-skeleton-loader type="card" />
            </v-col>
          </template>
          <template v-else>
            <template v-for="item in products.data">
              <product-card :product="item" :key="item.id" />
            </template>
          </template>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'UserProducts',
  data: function () {
    return {
      products: {
        data: [],
        link: null,
        meta: null,
        loading: true
      },
      brands: {
        data: [],
        loading: true,
        selected: []
      },
      categories: {
        data: [],
        links: null,
        meta: null,
        loading: true,
        selected: null
      },
      price: {
        start: 0,
        end: 0
      },
      keyword: '',
      orderBy: '',
      orderByOptions: [
        { text: 'Newest First', value: '' },
        { text: 'Price: Low - High', value: 'asc' },
        { text: 'Price: High - Low', value: 'desc' }
      ],
    }
  },
  async created () {
    this.categories.selected = this.$route.params.category_name
    await Promise.allSettled([this.fetchBrands(), this.fetchCategories()]).then(resutls => {
      resutls.forEach((result, index) => {
        if (result.status === 'fulfilled') {
          if (index === 0) {
            this.fetchBrandsSuccess(result)
          }
          if (index === 1) {
            this.fetchCategoriesSuccess(result.value)
          }
        }
        if (result.status === 'rejected') {
          this.$store.dispatch('showSnackbar', {
            message: result.reason.toString(),
            color: 'error'
          })
        }
      })
    })
    this.fetchProducts()
  },
  methods: {
    fetchBrands () {
      return this.$store.dispatch('brand/fetchBrandsPublic')
    },
    fetchBrandsSuccess (result) {
      this.brands.loading = false
      console.log(result)
      this.brands.data = result.value.results
    },
    fetchCategories () {
      return this.$store.dispatch('category/fetchCategories', 'main?limit=0')
    },
    fetchCategoriesSuccess (result) {
      this.categories.loading = false
      this.categories.data = result.data
      this.categories.links = result.links
      this.categories.meta = result.meta
    },
    async fetchProducts () {
      this.products.loading = true
      let query = []
      if (this.brands.selected.length > 0) query.push(`brand=${this.brands.selected.toString()}`)

      if (this.categories.selected) query.push(`category=${this.categories.selected}`)

      if (this.orderBy) query.push(`order_by=${this.orderBy}`)

      if (this.price.start > 0) query.push(`start_price=${this.price.start}`)

      if (this.price.end > 0 && this.price.end > this.price.start) query.push(`end_price=${this.price.end}`)

      if (this.keyword) query.push(`keywords=${this.keyword}`)
      // query.push(`new_arrival=yes&sale=no`)

      query = query.join('&')
      const res =  await this.$axios.get(`/api/v1/products/public/main?${query}`)
      if (res.status === 200 ) {
        this.products.data = res.data.data
        this.products.link = res.data.link
        this.products.meta = res.data.meta
        this.products.loading = false
        return res.data
      }
    }
  }
}
</script>

<style>

</style>