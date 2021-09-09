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
      <v-data-table
        v-else
        :headers="headerProducts"
        :items="products.data"
        :server-items-length="products.meta.total"
        class="elevation-1"
        :items-per-page="10"
      >
        <template v-slot:item.base_price="{item}">
          Rp {{item.base_price ? item.base_price.toLocaleString('id') : ''}}
        </template>
        <template v-slot:item.discount_price="{item}">
          {{ item.discount_price && parseInt(item.discount_price) > 0 ? 'Rp': '' }} {{item.discount_price ? item.discount_price.toLocaleString('id') : ''}}
        </template>
        <template v-slot:item.actions="{item}">
          <v-icon color="primary" class="mr-3" @click="toDetailProduct(item.id)">mdi-eye</v-icon>
          <v-icon color="warning" class="mr-3" @click="toEditProduct(item.id)">mdi-pencil</v-icon>
          <v-icon color="error" class="mr-3" @click="toggleDialogDelete(item)">mdi-trash-can</v-icon>
        </template>
      </v-data-table>
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
      products: {
        data: [],
        links: '',
        meta: null
      },
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
    fetchAdminProducts () {
      this.loading = true
      this.$store.dispatch("product/adminFetchProducts", `main?${this.limit}`).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.products.data = result.data
          this.products.meta = result.meta
          this.products.links = result.links
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    resolveImagePath (path) {
      return '../storage/' + path
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
