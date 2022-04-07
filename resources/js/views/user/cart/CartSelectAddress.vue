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
              <v-card-text v-if="paymentTypes.loading" class="text-center">
                <v-progress-circular indeterminate color="black" />
              </v-card-text>
              <template v-else>
                <v-card-text v-if="paymentTypes.error">
                  <v-alert type="error" prominent>An error occured. Please refresh the page.</v-alert>
                </v-card-text>
                <template v-else>
                  <v-card-text>
                    <p><strong>Select payment options</strong></p>
                    <v-radio-group v-model="selectedPayOpt" hide-details>
                      <template v-for="(opt, index) in paymentTypes.data">
                        <div class="mb-3" :key="index">
                          <v-radio :value="opt.id" :label="opt.name"/>
                        </div>
                      </template>
                    </v-radio-group>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-text v-if="!banks.loading && banks.data && banks.data.length > 0">
                    <p><strong>Select Bank</strong></p>
                    <div class="d-flex">
                      <div
                        v-for="(bank, index) in banks.data[0].bank"
                        :key="index"
                        class="pa-2 bank-item"
                        :class="{ 'bank-selected': bank.id === selectedBank }"
                        @click="handleSelectBank(bank.id)"
                      >
                        <v-img
                          :src="bank.image_path" 
                          :alt="bank.alt_image" 
                          max-width="100px" 
                        />
                      </div>
                    </div>
                  </v-card-text>
                </template>
              </template>
            </v-card>
            <!-- Note -->
            <v-card class="mt-3">
              <v-card-text>
                <v-textarea v-model="checkoutParams.note" label="Note" />
              </v-card-text>
            </v-card>
            <v-btn @click="createOrder" color="black" :disabled="total === 0" :loading="isSubmitting" class="white--text mt-4" block>Checkout</v-btn>
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
  watch: {
    selectedPayOpt(newVal, oldVal) {
      this.getBanks(newVal)
      this.selectedBank = null
    }
  },
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
      paymentTypes: {
        data: null,
        loading: true,
        error: false,
      },
      banks: {
        data: null,
        loading: true,
        error: false,
      },
      isSubmitting: false,
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
      selectedPayOpt: null,
      selectedBank: null,
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
    },
    isInstallment() {
      const installmentType = this.paymentTypes.data.find(p => p.key_name === "installment")
      return this.selectedPayOpt === installmentType.id
    }
  },
  mounted () {
    this.getProducts()
    this.getCustomerAddress()
    this.getPaymentTypes()
  },
  methods: {
    createOrder() {
      this.checkoutParams.is_installment = this.isInstallment ? true : false
      this.checkoutParams.total_installment = this.isInstallment ? this.total : 0
      this.checkoutParams.total_base_price = this.itemTotal
      this.checkoutParams.discount_price = this.discount
      this.checkoutParams.total_final_price = this.total
      this.checkoutParams.handling_fee = 0
      this.checkoutParams.products = this.carts.data.map(product => product.id)
      debugger
      this.isSubmitting = true
      this.$axios({
        url: `/api/v1/checkout/processed`,
        baseURL: process.env.MIX_APP_URL,
        method: 'POST',
        data: this.checkoutParams,
      })
      .then(result => {
        console.log("scheckout", result)
        debugger;
      })
      .finally(() => this.isSubmitting = false)
    },
    handleSelectBank(bankId) {
      this.selectedBank = bankId
    },
    getBanks(paymentTypeId) {
      this.banks.error = false
      this.banks.loading = true
      this.$axios({
        url: `/api/v1/banks/private/${paymentTypeId}`,
        baseURL: process.env.MIX_APP_URL,
      })
      .then(result => {
        this.banks.data = result.data.results
      })
      .catch(error => {
        this.banks.error = true
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      })
      .finally(() => this.banks.loading = false)
    },
    openDialogCreateAddress() {
      this.dialog = true
    },
    getPaymentTypes() {
      this.$axios({
        url: `/api/v1/payments-types`,
        baseURL: process.env.MIX_APP_URL,
      })
      .then(result => {
        this.paymentTypes.data = result.data.results
      })
      .catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      })
      .finally(() => this.paymentTypes.loading = false)
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
              baseURL: process.env.MIX_APP_URL,
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

<style scoped>
  .bank-item {
    border: 2px solid #fff;
    border-radius: 2px;
  }
  .bank-selected {
    border: 2px solid #ddd;
    border-radius: 2px;
  }
</style>