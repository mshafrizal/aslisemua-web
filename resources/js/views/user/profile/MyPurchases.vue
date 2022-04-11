<template>
  <div class="d-flex flex-column" v-if="!myPurchases.loading && !myPurchases.error">
    <template v-if="myPurchases.data.data.length > 0">
      <v-card outlined class="mb-4" v-for="purchase in myPurchases.data.data" :key="purchase.id">
        <v-card-title class="d-flex justify-space-between">
          <div>
            <strong>{{ purchase.created_at }}</strong>
          </div>
          <div class="d-flex justify-end">
            <v-btn
              v-if="purchase.payment_status.toLowerCase() === 'unpaid'"
              color="primary"
              outlined
              @click="resumePayment(purchase.snap_token)"
            >
              Pay
            </v-btn>
          </div>
          </v-card-title>
        <v-divider />
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="4" class="d-flex flex-column">
              <div class="font-weight-bold black--text">Transaction ID</div>
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
        <v-divider />
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="4" class="d-flex flex-column">
              <div class="font-weight-bold black--text">Billed To</div>
              <div>{{ purchase.billing_name }}</div>
              <div>{{ purchase.billing_email }}</div>
              <div>{{ purchase.billing_phone_number }}</div>
              <div>{{ purchase.billing_address }}</div>
              <div>{{ purchase.billing_city }}, {{ purchase.billing_district }}</div>
              <div>{{ purchase.billing_zip_code }}</div>
            </v-col>
            <v-col cols="12" sm="3" class="d-flex flex-column">
              <div class="font-weight-bold black--text">Shipping To</div>
              <div>{{ purchase.shipping_name }}</div>
              <div>{{ purchase.shipping_email }}</div>
              <div>{{ purchase.shipping_phone_number }}</div>
              <div>{{ purchase.shipping_address }}</div>
              <div>{{ purchase.shipping_city }}, {{ purchase.shipping_district }}</div>
              <div>{{ purchase.shipping_zip_code }}</div>
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
      }
    }
  },
  mounted() {
    this.getMyPurchases(`/api/v1/orders/public/limit/5`)
  },
  methods: {
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