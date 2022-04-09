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
                <td>{{ order.order_status }}</td>
                <td>{{ order.payment_status }}</td>
                <td>{{ order.shipping_status }}</td>
                <td>{{ order.billing_name }}</td>
                <td>{{ order.is_installment ? order.total_installment.toLocaleString('id') : order.total_final_price.toLocaleString('') }}</td>
                <td>{{ order.created_at }}</td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
      <v-col v-if="order.data && !order.loading">
        <div class="mx-auto d-flex justify-between" style="max-width: 300px">
          <template v-for="link in order.data.links">
            <v-btn :disabled="!link.url" :color="link.active ? 'primary': ''" small depressed @click="fetchBrands(link.url)" v-html="link.label" :key="link.label"></v-btn>
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
                loading: false,
            }
        }
    },
    methods: {
    }
}
</script>

<style>

</style>