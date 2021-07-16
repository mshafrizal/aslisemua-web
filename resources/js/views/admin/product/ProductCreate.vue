<template>
  <v-row>
    <v-col cols="12">Create Product</v-col>
    <v-col cols="12">
      <v-form v-model="valid" ref="formCreateProduct">
        <v-card>
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
          <v-divider />
          <v-card-actions>
            <v-btn @click="$router.push('/admin/product/list')" :disabled="isSubmitting" text color="error">Cancel</v-btn>
            <v-btn @click="handleCreateProduct" :loading="isSubmitting" depressed color="primary">Submit</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-col>
  </v-row>
</template>

<script>
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
export default {
  name: "ProductCreate",
  components: {
    TiptapVuetify
  },
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
    },
    handleChangeDiscount () {
      this.formCreateProduct.final_price = this.formCreateProduct.base_price - this.formCreateProduct.discount_price
    },
    handleCreateProduct (event) {
      event.preventDefault()
      if (this.formCreateProduct.images.length === 0) {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: 'Please provide product images',
          type: 'warning'
        })
        return
      }
      if (this.formCreateProduct.final_price <= 0) {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: 'Final price must have positive value',
          type: 'warning'
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
      this.$store.dispatch('product/adminCreateProduct', params).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            type: 'success',
            message: result.message
          })
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: error,
          type: 'error'
        })
      }).finally(() => {
        this.isSubmitting = false
        this.$router.push('/admin/product/list')
      })
    }
  }
}
</script>

<style scoped>

</style>