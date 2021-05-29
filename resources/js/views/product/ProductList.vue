<template>
  <v-row>
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
    <v-col cols="12" sm="10"><h2>Product List</h2></v-col>
    <v-col cols="12" sm="2">
      <v-btn href="/admin/product/create" block>Add Product</v-btn>
    </v-col>
    <v-col cols="12">
      <v-data-table
        :headers="headerProducts"
        :items="products"
        :loading="loading"
        class="elevation-1"
        :items-per-page="10"
      >
        <template v-slot:item.base_price="{item}">
          Rp {{item.base_price ? item.base_price.toLocaleString('id') : ''}}
        </template>
        <template v-slot:item.discount_price="{item}">
          Rp {{item.discount_price ? item.discount_price.toLocaleString('id') : ''}}
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
export default {
  name: "ProductList",
  data: function () {
    return {
      products: [],
      dialogDelete: false,
      dialogUpdateStatus: false,
      headerProducts: [
        { text: 'Product Name', align: 'start', sortable: true, value: 'name' },
        { text: 'Brand', align: 'start', sortable: true, value: 'brand.name' },
        { text: 'Price', align: 'end', sortable: true, value: 'base_price' },
        { text: 'Discount', align: 'end', sortable: true, value: 'discount_price' },
        { text: 'Actions', align: 'center', sortable: false, value: 'actions' },
      ],
      isSubmitting: false,
      loading: true,
      selectedProduct: null
    }
  },
  created () {
    this.fetchAdminProducts()
  },
  methods: {
    fetchAdminProducts () {
      this.loading = true
      this.$store.dispatch("product/adminFetchProducts").then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.products = result.data
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
      this.$store.dispatch('product/adminDeleteProduct').then(result => {
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
      }).finally(() => this.isSubmitting = false)
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
      this.$router.push(`/admin/product/${id}/edit`)
    }
  }
}
</script>

<style scoped>

</style>
