<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      max-width="500px"
    >
      <v-card v-if="purchaseDetail" >
        <v-card-title>Transaction Detail</v-card-title>
        <v-card-text>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Invoice Number
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{purchaseDetail.data[0].order_id}}
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Order Date
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ purchaseDetail.data[0].created_at }}
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              <strong>Shipment Info</strong>
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Status
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              <div class="text-uppercase">
                <v-chip small label color="blue-grey" class="lighten-3 grey--text text--darken-3">
                  <v-icon small left>mdi-truck</v-icon>{{ removeUnderscore(purchaseDetail.data[0].shipping_status) }}
                </v-chip>
              </div>
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Receiver
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ purchaseDetail.data[0].shipping_name}}
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Address
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ purchaseDetail.data[0].shipping_address}}
              <br />
              {{ purchaseDetail.data[0].shipping_city}}, {{ purchaseDetail.data[0].shipping_district}}
              <br />
              {{ purchaseDetail.data[0].shipping_zip_code}}
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              <strong>Payment Info</strong>
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Total Purchase
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ 
                purchaseDetail.data[0].is_installment ? 
                purchaseDetail.data[0].total_installment.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) :
                purchaseDetail.data[0].total_final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
              }}
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Status
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              <div class="text-uppercase">
                <v-chip small label color="lime" class="lighten-3 green--text text--darken-2">
                  <v-icon small left>mdi-currency-usd</v-icon>{{ removeUnderscore(purchaseDetail.data[0].payment_status) }}
                </v-chip>
              </div>
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Billed to
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ purchaseDetail.data[0].billing_name}}
            </v-col>
          </v-row>
          <v-row justify="space-between" dense>
            <v-col cols="12" sm="4">
              Billing address
            </v-col>
            <v-col cols="12" sm="5" class="text-right">
              {{ purchaseDetail.data[0].billing_address}}
              <br />
              {{ purchaseDetail.data[0].billing_city}}, {{ purchaseDetail.data[0].billing_district}}
              <br />
              {{ purchaseDetail.data[0].billing_zip_code}}
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text>
          <template v-for="product in purchaseDetail.data[0].order_item">
            <div :key="product.id">
              <v-img class="mb-1" :src="product.image_path" :alt="product.alt_image" aspect-ratio="1" max-width="150px"></v-img>
              <p class="mb-0"><strong>{{product.brand_name}}</strong></p>
              <p class="mb-0">{{product.product_name}}</p>
              <p class="mb-0">{{product.final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}}</p>
            </div>
          </template>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-col cols="12" md="8">
      <div class="d-flex flex-column" v-if="!myPurchases.loading && !myPurchases.error">
        <template v-if="myPurchases.data.data.length > 0">
          <v-card outlined class="mb-4" v-for="purchase in myPurchases.data.data" :key="purchase.id">
            <v-card-title class="d-flex justify-space-between">
              <div>
                <strong>{{ purchase.created_at }}</strong>
              </div>
              <div class="d-flex justify-end">
                <v-menu
                  open-on-hover
                  bottom
                  left
                  offset-y
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="black"
                      dark
                      v-bind="attrs"
                      v-on="on"
                      icon
                    >
                      <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                  </template>

                  <v-list>
                    <v-list-item
                      v-if="purchase.payment_status.toLowerCase() === 'unpaid'"
                      @click="resumePayment(purchase.snap_token)"
                    >
                      <v-list-item-content>
                        <v-list-item-title v-text="'Pay'"></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                      v-if="purchase.payment_status.toLowerCase() === 'unpaid'"
                      @click="resumePayment(purchase.snap_token)"
                    >
                      <v-list-item-content>
                        <v-list-item-title v-text="'Cancel'"></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                      @click="viewTransaction(purchase.order_id)"
                    >
                      <v-list-item-content>
                        <v-list-item-title v-text="'Detail'"></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </div>
              </v-card-title>
            <v-divider />
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="4" class="d-flex flex-column">
                  <div class="font-weight-bold black--text">Invoice Number</div>
                  <div>{{purchase.order_id}}</div>
                </v-col>
                <v-col cols="12" sm="2" class="d-flex flex-column">
                  <div class="font-weight-bold black--text">Payment Status</div>
                  <div class="text-uppercase">
                    <v-chip small label color="lime" class="lighten-3 green--text text--darken-2">
                      <v-icon small left>mdi-currency-usd</v-icon>{{ removeUnderscore(purchase.payment_status) }}
                    </v-chip>
                  </div>
                </v-col>
                <v-col cols="12" sm="3" class="d-flex flex-column">
                  <div class="font-weight-bold black--text">Shipping Status</div>
                  <div class="text-uppercase">
                    <v-chip small label color="blue-grey" class="lighten-3 grey--text text--darken-3">
                      <v-icon small left>mdi-truck</v-icon>{{ removeUnderscore(purchase.shipping_status) }}
                    </v-chip>
                  </div>
                </v-col>
                <v-col cols="12" sm="3" class="d-flex flex-column">
                  <div class="font-weight-bold black--text">Total Purchases</div>
                  <div class="">
                    {{ purchase.total_final_price.toLocaleString('id-ID', { style: "currency", currency: "IDR" }) }}
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <v-btn v-if="myPurchases.data.next_page_url" color="black" class="white--text" :loading="myPurchases.loading" @click="getMyPurchases(myPurchases.data.next_page_url)">Load More</v-btn>
        </template>
        <template v-else>
          <v-alert
            prominent
            text
            type="info"
          >You haven't purchase any product</v-alert>
        </template>
      </div>
      <div v-else-if="!myPurchases.loading && myPurchases.error">
        <v-alert color="error" prominent>
          Something went wrong. Please refresh this page or contact admin for further information.
        </v-alert>
      </div>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "MyPurchases",
  data: function () {
    return {
      myPurchases: {
        data: null,
        loading: true,
        error: false,
      },
      dialog: false,
      purchaseDetail: null
    }
  },
  mounted() {
    this.getMyPurchases(`/api/v1/orders/public/limit/5`)
  },
  methods: {
    viewTransaction(orderId, limit = 5, link = "/api/v1/orders/private/order-items/") {
      this.$axios({
        url: link,
        method: 'POST',
        data: {
          "limit": limit,
          "order_id": orderId
        }
      })
      .then(response => {
        this.purchaseDetail = response.data.data
        this.dialog = true
      })
    },
    removeUnderscore(text) {
      if (text) return String(text).replaceAll('_', ' ')
    },
    resumePayment(snap_token) {
      let self = this
      if (!snap_token) return
      window.snap.pay(snap_token, {
        onSuccess: function() {
          window.location.reload()
        },
        onError: function(result) {
          self.$store.dispatch('showSnackbar', {
            type: 'error',
            message: result.status_message.toString()
          })
          window.snap.hide()
        },
        onPending: function(result) {
          console.log("onPending", result)
        },
        onClose: function (result) {
          console.log("onClose", result)
        }
      })
    },
    getMyPurchases(link = `/api/v1/orders/public/limit/5`) {
      this.myPurchases.loading = true
      this.myPurchases.error = false
      this.$axios({
        url: link,
        baseURL: process.env.MIX_APP_URL,
      })
      .then(response => {
        if (this.myPurchases.data) {
          response.data.data.data.forEach(order => this.myPurchases.data.data.push(order))
        } else {
          this.myPurchases.data = response.data.data
        }
      })
      .catch(error => {
        this.myPurchases.error = true
        console.log(error)
      })
      .finally(() => this.myPurchases.loading = false)
    }
  }
}
</script>

<style scoped>

</style>