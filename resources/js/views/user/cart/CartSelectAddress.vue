<template>
  <v-container class="mb-32 mt-10">
    <v-dialog
      v-model="dialog"
      max-width="600px"
      persistent
    >
      <v-card>
        <v-card-title>Add New Address</v-card-title>
        <v-form @submit.prevent="createAddress">
          <v-card-text>
            <v-text-field v-model="form.name" label="Receiver Name" color="black" required></v-text-field>
            <v-text-field v-model="form.phone" label="Phone" type="tel" color="black" required></v-text-field>
            <v-text-field v-model="form.address" label="Address" color="black" required></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-btn type="submit" color="black" class="white--text" :loading="form.loading" :disabled="!form.valid">Save</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <v-row>
      <v-col cols="12" class="d-flex justify-center">
        <h1 class="text-3xl mx-auto">CART</h1>
      </v-col>
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="7" lg="8" v-if="!carts.loading">
              <h3>Select Address</h3>
              <template v-if="shouldCreateAddress">
                <div class="mt-5">
                  <v-alert
                    type="warning"
                    dense
                    prominent
                  >
                    No address found. Please add to continue.
                  </v-alert>
                  <v-btn color="black" class="white--text" @click="openDialogCreateAddress">Add New Address</v-btn>
                </div>
              </template>
              <div class="mt-5">
                <v-radio-group v-model="selectedAddress">
                  <template v-for="(adr, index) in address.data">
                    <v-radio color="primary" :value="adr.id" :key="index" :label="adr.address">
                    </v-radio>
                  </template>
                </v-radio-group>
              </div>
            <template v-for="item in carts.data">
              <cart-item
                  :product="item.product"
                  :key="item.product_id"
                  @remove="handleRemove"
              />
            </template>
          </v-col>
          <v-col cols="12" md="5" lg="4">
            <!-- Calculation -->
            <v-card>
              <v-card-text>
                <p><strong>Item total:</strong> Rp {{ itemTotal.toLocaleString() }}</p>
                <p class="crimson--text"><strong>Discount:</strong> Rp {{ discount.toLocaleString() }}</p>
                <v-divider class="mt-5"></v-divider>
                <p class="mt-5"><strong>Total:</strong> Rp {{ total.toLocaleString() }}</p>
              </v-card-text>
            </v-card>
            <!-- Payment Option -->
            <v-card class="mt-3">
              <v-card-text>
                <p><strong>Select payment options</strong></p>
                <v-radio-group v-model="selectedPayOpt">
                  <template v-for="(opt, index) in paymentOptions">
                    <div class="mb-3" :key="index">
                      <v-radio :value="opt.value" :label="opt.name"/>
                    </div>
                  </template>
                </v-radio-group>
              </v-card-text>
            </v-card>
            <!-- Note -->
            <v-card class="mt-3">
              <v-card-text>
                <v-textarea v-model="checkoutParams.note" label="Note" />
              </v-card-text>
            </v-card>
            <v-btn color="black" :disabled="total === 0" class="white--text mt-4" block>Checkout</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CartItem from '../../../components/shared/CartItem.vue'
export default {
  name: 'CartSelectAddress',
  components: {CartItem},
  data: function () {
    return {
      paymentOptions: [
        {
          name: "Full Payment",
          value: 1,
          active: true,
        },
        {
          name: "Installment",
          value: 0,
          active: false,
        }
      ],
      carts: {
        data: [],
        loading: true
      },
      address: {
        data: [],
        loading: true,
      },
      shouldCreateAddress: false,
      dialog: false,
      form: {
        valid: true,
        loading: false,
        name: "",
        phone: "",
        address: "",
        customer_id: "",
      },
      selectedAddress: null,
      checkoutParams: {
        note: "",
        is_installment: false,
        total_installment: 0,
        total_base_price: 0,
        discount_price: 0,
        total_final_price: 0,
        handling_fee: 0,
        products: [],
      }
    }
  },
  computed: {
    userInfo () {
      return JSON.parse(this.$store.getters['auth/authUserInfo'])
    },
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
  mounted () {
    this.getProducts()
    this.getCustomerAddress()
  },
  methods: {
    openDialogCreateAddress() {
      this.dialog = true
    },
    async createAddress() {
      this.form.customer_id = this.userInfo.id
      await this.$axios.post('/api/v1/customer-address', this.form)
        .then(result => {
          if (result.status === 201) {
            this.$store.dispatch('showSnackbar', {
              message: result.message,
              color: 'success'
            })
            this.shouldCreateAddress = false
          } else {
            this.$store.dispatch('showSnackbar', {
              message: result.message,
              color: "Customer not found"
            })
            console.log(result)
          }
            this.dialog = false
            this.form = {
              valid: true,
              loading: false,
              name: "",
              phone: "",
              address: "",
              customer_id: "",
            }
        })
        .then(() => window.location.reload())
      .catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      })
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
    },
    makeAddressDefault(addressObj) {
      this.$store.dispatch('customer/fetchAddresses')
      .then(result => {
        const addresses = result.results
        const defaultAddress = addresses.find(adress => adress.is_default > 0)
        
      })
    },
    getCustomerAddress () {
      let self = this
      this.address.loading = true
      this.$store.dispatch('customer/fetchAddresses').then(result => {
        if (result.results.length === 0) {
          this.shouldCreateAddress = true
          return false
        } else {
          this.address.data = result.results
          const hasDefaultAddress = this.address.data.find(address => address.is_default > 0)
          if (!hasDefaultAddress) {
            return true
          } else {
            this.selectedAddress = hasDefaultAddress.id
            return false
          }
        }
      })
      .then(async (shouldUpdateDefault) => {
        if (shouldUpdateDefault) {
          await this.$axios({
              url: '/api/v1/customer-address/address/status',
              baseURL: process.env.APP_URL,
              method: 'PUT',
              data: {
                customer_id: this.userInfo.id,
                address_id: this.address.data[0].id
              }
            })
        }
      })
      .catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      }).finally(() => this.address.loading = false)
    }
  }
}
</script>

<style>

</style>