<template>
  <v-container class="mb-32 mt-10">
    <v-row v-if="!loading">
      <v-col cols="12" sm="8">
        <v-row>
          <v-col cols="12" sm="2">
            <template v-for="image in product.product_image">
              <v-img @click="selectImage(image)" :src="resolveImagePath(image.image_path)" class="mb-5" :key="image.id"/>
            </template>
          </v-col>
          <v-col cols="12" sm="10" class="d-flex items-start justify-center">
            <div style="max-width: 600px">
              <zoom-image :img-normal="selectedImagePath" :scale="2"/>
            </div>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12" sm="4">
        <v-row>
          <v-col class="flex-grow-1">
            <h1 class="text-2xl font-weight-bold">{{ product.brand.name || '' }}</h1>
          </v-col>
          <v-col class="flex-grow-0">
            <v-btn @click="addToWishlist" icon><v-icon>mdi-heart-outline</v-icon></v-btn>
          </v-col>
        </v-row>
        <p>{{product.name || ''}}</p>
        <p class="text-xl text-yellow-500">Rp {{product.final_price.toLocaleString() || ''}}</p>

        <div class="my-5">
          <v-btn @click="addToCart" class="white--text" color="black" block>Add to Cart</v-btn>
        </div>

        <p class="font-weight-bold">Description</p>
        <div class="w-full">
          <div v-html="product.description"></div>
        </div>

        <p class="font-weight-bold">Details</p>
        <div class="w-full">
          <div v-html="product.details"></div>
        </div>

        <p class="font-weight-bold">Condition</p>
        <div class="w-full">
          <div v-html="product.condition"></div>
        </div>
        <v-divider class="my-5"/>
        <p class="font-weight-bold">Authentication</p>
        <p class="text-sm">
          We authenticate every item with a rigorous process overseen by experts.<br />
          <u>Learn more & see our authentication process.</u><br />

          Photos are of the actual item in our possession.
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ZoomImage from "../../../components/shared/ZoomImage";
export default {
  name: "UserProductDetail",
  components: {ZoomImage},
  data: function () {
    return {
      product: null,
      loading: true,
      selectedImagePath: null
    }
  },
  created () {
    this.getProduct()
  },
  methods: {
    addToCart () {

    },
    addToWishlist () {

    },
    getProduct () {
      this.loading = true
      this.$axios.get(`/api/v1/products/public/detail/${this.$route.params.slug}`).then(response => {
        console.log(response)
        if (response.status === 200) {
          this.product = response.data.results.data
          this.selectImage(this.product.product_image[0])
        }
      }).catch(error => {
        if (error.response) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.response.data.message,
            type: 'error'
          })
        }
      }).finally(() => this.loading = false)
    },
    resolveImagePath (path) {
      return '/storage/' + path
    },
    selectImage (image) {
      this.selectedImagePath = this.resolveImagePath(image.image_path)
    }
  }
}
</script>

<style scoped>
  .img-fluid {
    max-width: 600px;
  }
</style>
