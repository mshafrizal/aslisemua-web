<template>
  <v-row>
    <v-col class="flex-grow-1">
      <h2>Order List</h2>
    </v-col>
    <v-col cols="12">
      <v-skeleton-loader v-if="orders.loading" type="table" />
      <v-simple-table v-else>
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
            }
        }
    },
    mounted() {
      this.getOrderList(`/api/v1/orders/private/list/back-office`)
    },
    methods: {
      removeUnderscore(text) {
        if (text) return String(text).replaceAll('_', ' ')
      },
      getOrderList(link = `/api/v1/orders/private/list/back-office`) {
        this.orders.loading = true
        this.$axios({
          url: link,
          baseURL: process.env.MIX_APP_URL,
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

<style>
</style> 