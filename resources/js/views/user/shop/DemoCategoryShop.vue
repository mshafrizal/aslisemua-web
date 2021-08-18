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
              :items="categories"
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
            <v-col :key="product.id" cols="6" sm="4" md="3">
              <product-item :product="product" :key="product.id"/>
            </v-col>
          </template>
        </v-row>
        <v-row>
          <!-- <v-col cols="12" class="d-flex justify-space-between">
            <v-btn icon outlined color="black" :disabled="page === 1">
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn icon outlined color="black" :disabled="noMoreData">
              <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
          </v-col> -->
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
      categories: [
        {
          id: 1,
          name: 'Men\'s',
          file_path: '/images/dummyProduct/cat-men.jpg',
          parent: 'null',
          children: []
        },
        {
          id: 2,
          name: 'Women\'s',
          file_path: '/images/dummyProduct/cat-women.jpg',
          parent: 'null',
          children: []
        },
        {
          id: 3,
          name: 'Bag\'s',
          file_path: '/images/dummyProduct/cat-bag.jpg',
          parent: 'null',
          children: []
        },
        {
          id: 4,
          name: 'Watches',
          file_path: '/images/dummyProduct/cat-watch.jpg',
          parent: 'null',
          children: []
        },
        {
          id: 5,
          name: 'Jewelry',
          file_path: '/images/dummyProduct/cat-jewelry.jpg',
          parent: 'null',
          children: []
        },
        {
          id: 6,
          name: 'Kid\'s',
          file_path: '/images/dummyProduct/cat-kids.jpg',
          parent: 'null',
          children: []
        }
      ],
      colorOptions: [],
      color: '',
      brands: [],
      keyword: '',
      loading: false,
      orderBy: '',
      orderByOptions: [
        { text: 'Newest First', value: '' },
        { text: 'Price: Low - High', value: 'asc' },
        { text: 'Price: High - Low', value: 'desc' }
      ],
      page: 1,
      products: {
        data: [
        {
          id: 1,
          products_images: [
            {
              image_path: '/images/dummyProduct/hermes-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/hermes-2.jpg'
            },
            {
              image_path: '/images/dummyProduct/hermes-3.jpg'
            }
          ],
          brand: {
            name: 'Hermes'
          },
          name: 'Tote bag',
          size: 'Large',
          slug: 'tote-bag',
          final_price: 12500000
        },
        {
          id: 2,
          products_images: [
            {
              image_path: '/images/dummyProduct/gucci-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/gucci-2.jpg'
            }
          ],
          brand: {
            name: 'Gucci'
          },
          name: 'Suede Drivers',
          size: '42',
          slug: 'suede-drivers',
          final_price: 3360000
        },
        {
          id: 4,
          products_images: [
            {
              image_path: '/images/dummyProduct/fendi-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/fendi-2.jpg'
            },
            {
              image_path: '/images/dummyProduct/fendi-3.jpg'
            }
          ],
          brand: {
            name: 'Fendi'
          },
          name: 'Roma Clutch Tan',
          size: 'Large',
          slug: 'roma-clutch-tan',
          final_price: 51000000
        },
        ]
      },
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
    // this.getCategories()
    // this.getBrands()
    // this.getProducts ()
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

  // computed: {
  //   computedCategories () {
  //     if (this.categories) {
  //       const parent = this.categories.data.filter(category => category.parent === 'null' || !category.parent)
  //       parent.forEach(category => {
  //         category.children = this.categories.data.filter(sub => sub.parent === category.id)
  //       })
  //       return parent
  //     }
  //     return []
  //   },
  //   noMoreData () {
  //     if (this.products) {
  //       if (!this.products.links.next) return true
  //       else return false
  //     }
  //   }
  // }
}
</script>

<style scoped>

</style>
