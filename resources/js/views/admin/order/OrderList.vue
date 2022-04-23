<template>
  <v-row>
    <v-dialog 
      v-model="dialog"
      fullscreen
      hide-overlay 
      transition="dialog-bottom-transition"
    >
      <v-dialog v-model="dialogCancel" max-width="300">
        <v-card>
          <v-card-title>Cancel Order</v-card-title>
          <v-card-text>Are you sure to cancel this order?</v-card-text>
          <v-card-actions>
            <v-btn text @click="dialogCancel = false" :disabled="isSubmitting">No</v-btn>
            <v-btn depressed color="error" @click="cancelOrder" :loading="isSubmitting">Yes</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-card v-if="orderDetail.data">
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false"><v-icon>mdi-close</v-icon></v-btn>
          <v-toolbar-title>            
            Order Detail
          </v-toolbar-title>
        </v-toolbar>
        <v-card-text class="mt-3">
          <v-row>
            <v-col cols="12" sm="4">
              <v-card class="">
                <v-card-title>Order Info</v-card-title>
                <v-divider />
                <v-card-text>
                  <v-row dense class="caption">
                    <v-col cols="3" class="text-right caption">
                      <strong>Order Id</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].order_id}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Created at</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].created_at}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Customer</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_name}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Amount</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{parseInt(orderDetail.data.data[0].is_installment) > 0 ? parseInt(orderDetail.data.data[0].total_installment).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) : parseInt(orderDetail.data.data[0].total_final_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Order Status</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].order_status}}</p>
                      <!-- <v-btn outlined x-small>Change Status</v-btn> -->
                      <v-btn 
                        color="error" 
                        outlined
                        x-small
                        @click="confirmCancelOrder(orderDetail.data.data[0].order_id)"
                        v-if="orderDetail.data.data[0].order_status != 'cancelled'"
                        >Cancel Order</v-btn>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Payment Status</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].payment_status}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Shipment Status</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_status}}</p>
                      <v-btn outlined x-small>Change Status</v-btn>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" sm="4">
              <v-card class="">
                <v-card-title>Shippment Info</v-card-title>
                <v-divider />
                <v-card-text>
                  <v-row dense class="caption">
                    <v-col cols="3" class="text-right caption">
                      <strong>Receiver Name</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_name}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Phone</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_phone}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Address</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_address}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>District</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_district}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>City</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_city}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Zip Code</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].shipping_zip_code}}</p>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" sm="4">
              <v-card class="">
                <v-card-title>Billing Info</v-card-title>
                <v-divider />
                <v-card-text>
                  <v-row dense class="caption">
                    <v-col cols="3" class="text-right caption">
                      <strong>Billed to</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_name}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Email</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_email}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Phone</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_phone}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Address</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_address}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>District</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_district}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>City</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_city}}</p>
                    </v-col>
                    <v-col cols="3" class="text-right caption">
                      <strong>Zip Code</strong>
                    </v-col>
                    <v-col cols="9" class="text-left">
                      <p class="mb-1">{{orderDetail.data.data[0].billing_zip_code}}</p>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12">
              <v-card>
                <v-card-title>Products</v-card-title>
                <v-card-text>
                  <v-simple-table>
                    <thead>
                      <tr>
                        <th>Picture</th>
                        <th>Brand</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in orderDetail.data.data[0].order_item" :key="index">
                        <td>
                          <v-responsive aspect-ratio="1/1">
                            <v-img :src="item.image_path" max-width="100" max-height="100" />
                          </v-responsive>
                        </td>
                        <td>{{item.brand_name}}</td>
                        <td>{{item.product_name}}</td>
                        <td>{{parseInt(item.base_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}}</td>
                        <td>{{parseInt(item.discount_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}}</td>
                        <td>{{parseInt(item.final_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}}</td>
                      </tr>
                    </tbody>
                  </v-simple-table>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-col class="flex-grow-1">
      <h2>Order List</h2>
    </v-col>
    <v-col cols="12">
      <v-skeleton-loader v-if="orders.loading" type="table" />
      <v-simple-table v-else id="ordersTable">
        <template v-slot:default>
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Order Status</th>
              <th>Payment Status</th>
              <th>Shipping Status</th>
              <th>Customer</th>
              <th>Amount</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="order in orders.data.data">
              <tr :key="order.id">
                <td>{{ order.order_id }}</td>
                <td class="text-uppercase">
                  <v-chip small label color="yellow" class="lighten-3 orange--text text--darken-2">
                    <v-icon small left>mdi-receipt</v-icon> {{ removeUnderscore(order.order_status) }}
                  </v-chip>
                </td>
                <td class="text-uppercase">
                  <v-chip small label color="lime" class="lighten-3 green--text text--darken-2">
                    <v-icon small left>mdi-currency-usd</v-icon>{{ order.payment_status }}
                  </v-chip>
                </td>
                <td class="text-uppercase">
                  <v-chip small label color="blue-grey" class="lighten-3 grey--text text--darken-3">
                    <v-icon small left>mdi-truck</v-icon>{{ order.shipping_status }}
                  </v-chip>
                </td>
                <td>{{ order.billing_name }}</td>
                <td>{{ order.is_installment ? order.total_installment.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) : order.total_final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</td>
                <td>{{ order.created_at }}</td>
                <td>
                  <v-btn @click="viewOrderDetail(order.order_id)" icon color="primary">
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                </td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
      <v-col v-if="orders.data && !orders.loading">
        <div class="mx-auto d-flex justify-between" style="max-width: 300px">
          <template v-for="link in orders.data.links">
            <v-btn :disabled="!link.url" :color="link.active ? 'primary': ''" small depressed @click="getOrderList(link.url)" v-html="link.label" :key="link.label"></v-btn>
          </template>
        </div>
      </v-col>
    </v-col>
  </v-row>
</template>

<script>
export default {
    data: function() {
        return {
            orders: {
                data: null,
                loading: true,
            },
            dialog: false,
            dialogCancel: false,
            isSubmitting: false,
            orderDetail: {
                data: null,
                loading: false,
            },
            selectedOrderId: "",
        }
    },
    mounted() {
      this.getOrderList(`/api/v1/orders/private/list/back-office`)
    },
    methods: {
      cancelOrder() {
        this.isSubmitting = true
        this.$axios({
          url: '/api/v1/orders/private/cancel-order',
          method: 'POST',
          data: {
            order_id: this.selectedOrderId,
          }
        }).then(response => {
          this.$store.dispatch('showSnackbar', {
            type: 'success',
            message: response.data.message
          })
        }).catch(error => {
          this.$store.dispatch('showSnackbar', {
            type: 'error',
            message: error.response.data.message
          })
        }).finally(() => {
          this.isSubmitting = false
          this.selectedOrderId = ""
          this.dialogCancel = false
        })
      },
      confirmCancelOrder(order_id) {
        this.selectedOrderId = order_id
        this.dialogCancel = true
      },
      viewOrderDetail(order_id) {
        this.loading = true
        this.dialog = true
        this.$axios({
          url: '/api/v1/orders/private/order-items',
          data: {
            order_id: order_id
          },
          method: 'POST'
        }).then(response => {
          this.orderDetail.data = response.data.data
        }).catch(error => {
          this.$store.dispatch('showSnackbar', {
            type: 'error',
            message: error
          })
        }).finally(() => this.loading = false)
      },
      removeUnderscore(text) {
        if (text) return String(text).replaceAll('_', ' ')
      },
      getOrderList(link = `/api/v1/orders/private/list/back-office`) {
        this.orders.loading = true
        this.$axios({
          url: link,
          
          method: 'POST'
        })
        .then(response => {
          this.orders.data = response.data.data
        })
        .catch(error => {
          this.$store.dispatch('showSnackbar', {
            type: 'error',
            message: error
          })
        })
        .finally(() => this.orders.loading = false)
      }
    }
}
</script>

<style scoped>
  #ordersTable > .v-data-table__wrapper > table > tbody > tr > td {
    font-size: 11px;
  }
</style>