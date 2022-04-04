<template>
  <v-container class="mb-32 mt-10">
    <v-row>
      <v-col cols="12" class="d-flex justify-center">
        <h1 class="text-3xl mx-auto">CART</h1>
      </v-col>
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="7" lg="8" v-if="!carts.loading">
            <template v-for="item in carts.data">
              <cart-item
                  :product="item.product"
                  :key="item.product_id"
                  @remove="handleRemove"
              />
            </template>
          </v-col>
          <v-col cols="12" md="5" lg="4">
            <v-card>
              <v-card-text>
                <p><strong>Item total:</strong> Rp {{ itemTotal.toLocaleString() }}</p>
                <p class="crimson--text"><strong>Discount:</strong> Rp {{ discount.toLocaleString() }}</p>
                <v-divider class="mt-5"></v-divider>
                <p class="mt-5"><strong>Total:</strong> Rp {{ total.toLocaleString() }}</p>
              </v-card-text>
            </v-card>
            <v-btn color="black" :disabled="total === 0" class="white--text mt-4" block @click="toSelectAddress">Checkout</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CartItem from '../../../components/shared/CartItem.vue'
export default {
  name: 'Cart',
  components: {CartItem},
  data: function () {
    return {
      carts: {
        data: [],
        loading: true
      }
    }
  },
  computed: {
    itemTotal () {
      if (!this.carts.loading && this.carts.data.length > 0) {
        return this.carts.data.map(product => parseInt(product.product.base_price)).reduce((a, b) => a += b)
      }
      return 0
    },
    discount () {
      if (!this.carts.loading && this.carts.data.length > 0) {
        return this.carts.data.map(product => parseInt(product.product.discount_price)).reduce((a, b) => a += b)
      }
      return 0
    },
    total () {
      return this.itemTotal - this.discount
    }
  },
  created () {
    this.getProducts()
  },
  methods: {
    toSelectAddress() {
      this.$router.push("/cart/select-address")
    },
    handleRemove (product_id) {
      console.log('handleRemove', product_id)
      this.carts.data = this.carts.data.filter(product => product.product_id !== product_id)
      this.$store.dispatch('cart/deleteProduct', product_id)
    },
    getProducts () {
      this.carts.loading = true
      this.$store.dispatch('cart/getProducts').then(result => {
        this.carts.data = result.data
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      }).finally(() => this.carts.loading = false)
    }
  }
}
</script>

<style>

</style>