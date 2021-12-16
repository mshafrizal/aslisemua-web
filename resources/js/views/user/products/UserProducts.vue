<template>
  <v-container class="mb-10">
    <!-- <pre>{{JSON.stringify(this.$route.params, null, 2)}}</pre> -->
    <v-row class="mt-5 mb-5">
      <v-col cols="12" class="text-center">
        <h1 class="text-3xl">{{ this.$route.query && this.$route.query.c_name ? this.$route.query.c_name : '' }}</h1>
      </v-col>
    </v-row>
    <v-row>
      
      <v-col cols="12" sm="3">
        <v-card outlined class="relative">
          <v-card-text>
            <v-skeleton-loader v-if="categories.loading" type="list-item" />
            <categories-filter v-else :items="computedCategory" @selected="handleSelectCategory" />
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
            />
            <v-btn class="mt-2 black white--text" @click="fetchProducts" block>Apply</v-btn>
          </v-card-text>
          <v-divider />
          <v-card-text>
            <brands-filter
              :items="brands.data"
                @brand-selected="handleSelectBrand"
            />
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
              <v-col cols="6" sm="3" :key="item.id">
                <product-card :product="item" :key="item.id" />
              </v-col>
            </template>
          </template>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CategoriesFilter from '../../../components/shared/CategoriesFilter.vue'
import BrandsFilter from '../../../components/shared/BrandsFilter.vue'
import ProductCard from '../../../components/shared/ProductCard.vue'
export default {
  name: 'UserProducts',
  components: {CategoriesFilter, BrandsFilter, ProductCard},
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
    this.categories.selected = this.$route.query && this.$route.query.c_name ? this.$route.query.c_name : '' 
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
  computed: {
    computedCategory () {
      if (this.categories.data.length > 0) {
        return this.categories.data.map(cat => {
          return {
            ...cat,
            children: this.categories.data.filter(child => {
              return child.parent === cat.id
            })
          }
        }).filter(cat => cat.parent === 'null' || !cat.parent)
      }
      return []
    }
  },
  methods: {
    handleSelectBrand (value) {
      if (value) {
        this.brands.selected = [value]
        this.$router.replace({ name: 'UserProducts', query: { ...this.$route.query, b_name: [value] } })
        this.fetchProducts()
      }
    },
    handleSelectCategory (value) {
      if (value) {
        this.categories.selected = value
        const category = this.categories.data.find(item => item.id === value)
        this.$router.replace({ name: 'UserProducts', query: { ...this.$route.query, c_name: category.name, c_id: category.id }}).catch(() => {})
        this.categories.selected = category.name
        this.fetchProducts()
      }
    },
    fetchBrands () {
      return this.$store.dispatch('brand/fetchBrandsPublic')
    },
    fetchBrandsSuccess (result) {
      this.brands.loading = false
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
      console.log(this.categories.selected)
      if (this.brands.selected.length > 0) query.push(`brand=${this.brands.selected.toString()}`)

      if (this.categories.selected) query.push(`category=${this.categories.selected}`)

      if (this.orderBy) query.push(`order_by=${this.orderBy}`)

      if (this.price.start >= 0) query.push(`start_price=${this.price.start}`)

      if (this.price.end >= 0 && this.price.end > this.price.start) query.push(`end_price=${this.price.end}`)

      if (this.keyword) query.push(`keywords=${this.keyword}`)
      // query.push(`new_arrival=yes&sale=no`)
      console.log('query', query)
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