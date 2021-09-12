<template>
  <v-dialog 
      v-model="open"
      fullscreen
      hide-overlay
      persistent
      transition="dialog-bottom-transition"
  >
    <v-card v-if="product.loading">
      <v-skeleton-loader
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-form v-else v-model="valid" ref="formCreateProduct" @submit.prevent="handleEditProduct">
      <v-toolbar
        dark
        color="primary"
      >
        <v-btn
          icon
          dark
          @click="handleClose"
          :disabled="isSubmitting"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>Edit Product</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn
            dark
            text
            type="submit"
            :loading="isSubmitting"
          >
            Submit
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card class="elevation-0">
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6">
              <h2>Product Information</h2>
              <v-divider></v-divider>
              <br />
              <v-row dense>
                <v-col cols="12">
                  <v-text-field id="product_name" v-model="formCreateProduct.name" label="Product Name" outlined dense></v-text-field>
                </v-col>

                <v-col cols="12" >
                  <v-select id="brand" v-model="formCreateProduct.brand_id" label="Brand" :rules="brandRules" :items="brands" outlined dense item-text="name" item-value="id"></v-select>
                </v-col>

                <v-col cols="12" >
                  <v-select id="category" v-model="formCreateProduct.category_id" label="Category" :items="categories" outlined dense item-text="name" item-value="id"></v-select>
                </v-col>

                <v-col cols="12">
                  <v-text-field id="size" v-model="formCreateProduct.size" label="Size" outlined dense></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-select id="gender" v-model="formCreateProduct.gender" label="Gender" :items="gender" outlined dense item-text="text" item-value="value"></v-select>
                </v-col>

                <v-col cols="12">
                  <v-text-field id="color" v-model="formCreateProduct.color" label="Color" outlined dense></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field id="condition" v-model="formCreateProduct.condition" label="Condition" outlined dense></v-text-field>
                </v-col>

                <v-col cols="12">
                  <div>
                    <label for="description">Description</label>
                    <tiptap-vuetify
                      id="description"
                      v-model="formCreateProduct.description"
                      :extensions="extensions"
                      placeholder="Description..."
                    />
                  </div>
                </v-col>

                <v-col cols="12">
                  <div>
                    <label for="detail">Detail</label>
                    <tiptap-vuetify id="detail" v-model="formCreateProduct.detail" :extensions="extensions" placeholder="Detail..."></tiptap-vuetify>
                  </div>
                </v-col>

              </v-row>
            </v-col>
            <v-col cols="12" sm="6">
              <h2>Price</h2>
              <v-divider></v-divider>
              <br />
              <v-row dense>
                <v-col cols="12">
                  <v-currency-field label="Base Price" v-model="formCreateProduct.base_price" @input="handleChangeDiscount" :rules="basePriceRules" outlined dense></v-currency-field>
                </v-col>

                <v-col cols="12">
                  <v-currency-field label="Discount" v-model="formCreateProduct.discount_price" @input="handleChangeDiscount" :rules="discountPriceRules" outlined dense></v-currency-field>
                </v-col>

                <v-col cols="12">
                  <v-currency-field label="Final Price" disabled v-model="formCreateProduct.final_price" :rules="finalPriceRules" outlined dense></v-currency-field>
                </v-col>
              </v-row>

              <h2>Product Images</h2>
              <v-divider></v-divider>
              <br />
              <v-row>
                <v-col cols="12">
                  <v-file-input
                    v-model="formCreateProduct.images"
                    multiple
                    label="Images"
                    prepend-icon="mdi-camera"
                    accept="image/png, image/jpeg, image/bmp"
                  >
                  </v-file-input>
                </v-col>
                <template v-for="(img, index) in imagesPreview">
                  <v-col cols="3" :key="index">
                    <v-img :src="img"></v-img>
                  </v-col>
                </template>
              </v-row>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-form>
  </v-dialog>
</template>

<script>
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
export default {
  name: "ProductEdit",
  components: {
    TiptapVuetify
  },
  props: ['open', 'id'],
  data: function () {
    return {
      basePriceRules: [
        v => !!v || 'Base Price is required'
      ],
      brands: [],
      brandRules: [
        v => !!v || 'Brand is required'
      ],
      categories: [],
      categoryRules: [
        v => !!v || 'Category is required'
      ],
      colorRules: [
        v => !!v || 'Color is required'
      ],
      dialogConfirmation: false,
      discountPriceRules: [
        v => !!v || 'Dicsount Price is required'
      ],
      extensions: [
        History,
        Blockquote,
        Link,
        Underline,
        Strike,
        Italic,
        ListItem,
        BulletList,
        OrderedList,
        [Heading, {
          options: {
            levels: [1, 2, 3]
          }
        }],
        Bold,
        HorizontalRule,
        Paragraph,
        HardBreak
      ],
      contentDescription: ``,
      contentDetail: ``,
      finalPriceRules: [
        v => !!v || 'Final Price is required',
        v => v >= 0 || 'Must have positive value'
      ],
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
      product: {
        loading: false,
        data: null
      },
      gender: [
        { text: 'Male', value: 'male' },
        { text: 'Female', value: 'female' },
        { text: 'None', value: '' }
      ],
      genderRules: [
        v => !!v || 'Gender is required'
      ],
      isSubmitting: false,
      loading: false,
      namerules: [
        v => !!v || 'Name is required'
      ],
      toggleMenuBar: [],
      valid: true
    }
  },
  computed: {
    imagesPreview () {
      if (this.formCreateProduct.images.length > 0) {
        let urls = []
        this.formCreateProduct.images.forEach(image => {
          urls.push(URL.createObjectURL(image))
        })
        return urls
      } else {
        return []
      }
    }
  },
  watch: {
    open: function (val, oldVal) {
      if (val === true) {
        this.fetchBrands()
        this.fetchCategories()
        this.fetchProduct()
      }
    }
  },
  methods: {
    fetchProduct () {
      this.product.loading = true
      this.$store.dispatch('product/adminFetchProduct', { product_id: this.id }).then(result => {
        console.log(result)
        this.product.data = result.results.data
        this.formCreateProduct = {
          name: result.results.data.name,
          brand_id: result.results.data.brand_id,
          category_id: result.results.data.category_id,
          size: result.results.data.size,
          gender: result.results.data.gender,
          color: result.results.data.color,
          condition: result.results.data.condition,
          description: result.results.data.description,
          detail: result.results.data.detail,
          discount_price: result.results.data.discount_price,
          alt_image: result.results.data.alt_image,
          base_price: result.results.data.base_price,
          final_price: result.results.data.final_price,
          images: []
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      }).finally(() => this.product.loading = false)
    },
    handleClose () {
      this.$emit('close')
    },
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
          
          message: error,
          color: 'error'
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
          
          message: error,
          color: 'error'
        })
        return false
      }).finally(() => this.loading = false)
    },
    handleChangeDiscount () {
      this.formCreateProduct.final_price = this.formCreateProduct.base_price - this.formCreateProduct.discount_price
    },
    handleEditProduct (event) {
      event.preventDefault()
      if (this.formCreateProduct.images.length === 0) {
        this.$store.dispatch('showSnackbar', {
          
          message: 'Please provide product images',
          color: 'warning'
        })
        return
      }
      if (this.formCreateProduct.final_price <= 0) {
        this.$store.dispatch('showSnackbar', {
          
          message: 'Final price must have positive value',
          color: 'warning'
        })
        return
      }
      this.isSubmitting = true
      let params = new FormData()
      params.append('name', this.formCreateProduct.name)
      params.append('brand_id', this.formCreateProduct.brand_id)
      params.append('category_id', this.formCreateProduct.category_id)
      params.append('size', this.formCreateProduct.size)
      params.append('gender', this.formCreateProduct.gender)
      params.append('color', this.formCreateProduct.color)
      params.append('condition', this.formCreateProduct.condition)
      params.append('description', this.formCreateProduct.description)
      params.append('detail', this.formCreateProduct.detail)
      params.append('discount_price', this.formCreateProduct.discount_price)
      params.append('base_price', this.formCreateProduct.base_price)
      params.append('final_price', this.formCreateProduct.final_price)
      params.append('stock', 1)
      params.append('alt_image', '')
      this.formCreateProduct.images.forEach(img => {
        params.append('images[]', img, img.name)
      })
      this.$store.dispatch('product/adminEditProduct', { product_id: this.id, data: params}).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            
            color: 'success',
            message: result.message
          })
          this.$emit('createSuccess')
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          
          message: error,
          color: 'error'
        })
      }).finally(() => {
        this.isSubmitting = false
        this.formCreateProduct = {
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
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
