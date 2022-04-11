<template>
  <v-row>
    <product-create :open="dialogCreateProduct" @close="handleClose" @createSuccess="handleSuccess"/>
    <product-edit :open="dialogEditProduct.open" :id="dialogEditProduct.id" @close="handleClose" @editSuccess="handleSuccess"/>
    <v-dialog v-model="dialogUpdateStatus" persistent>
      <v-card>
        <v-card-title>Change Product Status</v-card-title>
        <v-card-text>Are you sure to change this product status?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" :disabled="loading" text @click="toggleDialogStatus">Cancel</v-btn>
          <v-btn color="primary" :loading="loading" text>Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogDelete" v-if="dialogDelete" max-width="500">
      <v-card>
        <v-card-title>Delete Product</v-card-title>
        <v-card-text>Are you sure to delete {{this.selectedProduct.name}}?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" :disabled="isSubmitting" text @click="toggleDialogDelete">Cancel</v-btn>
          <v-btn color="primary" :loading="isSubmitting" text @click="submitDelete">Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-col class="flex-grow-1"><h2>Product List</h2></v-col>
    <v-col class="flex-grow-0">
      <v-btn @click="dialogCreateProduct = true" block>Add Product</v-btn>
    </v-col>
    <v-col cols="12">
      <v-skeleton-loader v-if="loading" type="table" />
      <v-simple-table v-else>
        <template v-slot:default>
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Final Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="product in products.data">
              <tr :key="product.id">
                <td>{{ product.name }}</td>
                <td class="text-uppercase">
                  {{ product.brand.name }}
                </td>
                <td class="text-uppercase">
                  {{ product.base_price}}
                </td>
                <td class="text-uppercase">
                  {{ product.discount_price }}
                </td>
                <td>{{ product.final_price }}</td>
                <td>
                  <div class="d-flex">
                    <v-btn color="primary" icon>
                      <v-icon>mdi-eye</v-icon>
                    </v-btn>
                    <v-btn color="warning" icon class="ml-2">
                      <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn color="error" icon class="ml-2">
                      <v-icon>mdi-trash</v-icon>
                    </v-btn>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
      <v-col v-if="products && !loading">
        <div class="d-flex flex-grow-1 justify-space-between">
          <v-btn :disabled="!products.links.prev" icon @click="fetchAdminProducts(products.links.prev)">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-btn :disabled="!products.links.next" icon @click="fetchAdminProducts(products.links.next)">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </div>
      </v-col>
    </v-col>
  </v-row>
</template>

<script>
import ProductCreate from './ProductCreate.vue'
import ProductEdit from './ProductEdit.vue'
export default {
  name: "ProductList",
  components: {ProductCreate, ProductEdit},
  data: function () {
    return {
      products: null,
      dialogDelete: false,
      dialogUpdateStatus: false,
      headerProducts: [
        { text: 'Product Name', align: 'start', sortable: true, value: 'name' },
        { text: 'Brand', align: 'start', sortable: true, value: 'brand.name' },
        { text: 'Price', align: 'end', sortable: true, value: 'base_price' },
        { text: 'Discount', align: 'end', sortable: true, value: 'discount_price' },
        { text: 'Actions', align: 'center', sortable: false, value: 'actions' },
      ],
      dialogEditProduct: {
        open: false,
        id: ''
      },
      dialogCreateProduct: false,
      isSubmitting: false,
      loading: true,
      selectedProduct: null,
      limit: 16
    }
  },
  created () {
    this.fetchAdminProducts()
  },
  methods: {
    handleClose () {
      this.dialogCreateProduct = false
      this.dialogEditProduct.open = false
      this.dialogEditProduct.id = ''
    },
    handleSuccess () {
      this.fetchAdminProducts()
    },
    fetchAdminProducts (link = `/api/v1/products/private`) {
      this.loading = true
      this.$axios({
        url: link,
        baseURL: process.env.MIX_APP_URL
      }).then(({ data }) => {
        this.products = {
          data: data.data,
          links: data.links,
          meta: data.meta
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    submitDelete () {
      this.isSubmitting = true
      const params = {
        product_id: this.selectedProduct.id
      }
      this.$store.dispatch('product/adminDeleteProduct', params).then(result => {
        if (result.status >= 400) throw new Error (result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            type: 'success',
            message: result.message
          })
          this.toggleDialogDelete()
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error.response.message || error.toString()
        })
      }).finally(() => {
        this.isSubmitting = false
        this.fetchAdminProducts()
      })
    },
    toggleDialogDelete (product) {
      if (this.dialogUpdateStatus) this.selectedProduct = null
      else this.selectedProduct = product
      this.dialogDelete = !this.dialogDelete
    },
    toggleDialogStatus (product) {
      if (this.dialogUpdateStatus) this.selectedProduct = null
      else this.selectedProduct = product
      this.dialogUpdateStatus = !this.dialogUpdateStatus
    },
    toDetailProduct (id) {
      this.$router.push(`/admin/product/${id}/detail`)
    },
    toEditProduct (id) {
      this.dialogEditProduct.id = id
      this.dialogEditProduct.open = true
    }
  }
}
</script>

<style scoped>

</style>
