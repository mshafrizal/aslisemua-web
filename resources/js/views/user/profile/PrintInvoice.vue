<template>
  <div class="print-wrapper" v-if="!orderDetail.loading">
    <div class="d-flex flex-column">
      <h1 class="logo">ASLISEMUA</h1>
      <p class="mb-0">PT Mobiliari Stephindo</p>
      <p>Jalan KH Wahid Hasyim Nomor 55 RT 1 RW.4</p>
      <div>
        <h2 class="print-heading">INVOICE # {{ orderDetail.data.order_id }}</h2>
        <p>Order Date: {{ orderDetail.data.created_at }}</p>
      </div>
      <div class="d-flex">
        <div class="flex-grow-1">
          <h2 class="print-heading">SHIPPING ADDRESS</h2>
          <p>{{ orderDetail.data.shipping_name }} </p>
          <p>{{ orderDetail.data.shipping_phone_number }} </p>
          <p>{{ orderDetail.data.shipping_address }} </p>
          <p>{{ orderDetail.data.shipping_district }} </p>
          <p>{{ orderDetail.data.shipping_city }} </p>
          <p>{{ orderDetail.data.shipping_zip_code }} </p>
        </div>
        <div class="flex-grow-1">
          <h2 class="print-heading">BILLING ADDRESS</h2>
          <p>{{ orderDetail.data.billing_name }} </p>
          <p>{{ orderDetail.data.billing_phone_number }} </p>
          <p>{{ orderDetail.data.billing_address }} </p>
          <p>{{ orderDetail.data.billing_district }} </p>
          <p>{{ orderDetail.data.billing_city }} </p>
          <p>{{ orderDetail.data.billing_zip_code }} </p>
        </div>
      </div>
      <div>
        <h2>Items</h2>
        <table class="order-table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in orderDetail.data.order_item" :key="index"
            >
              <td>{{ item.product_name }}</td>
              <td>{{ item.final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</td>
              <td>1</td>
              <td>{{ item.final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="total">Total</td>
              <td>{{ orderDetail.data.total_final_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "PrintInvoice",
    data: function () {
        return {
            orderDetail: {
                loading: true,
                data: null
            }
        }
    },
    async mounted() { 
        await this.getOrderDetail()
        setTimeout(() => window.print(), 500)
    },
    methods: {
      async getOrderDetail() {
        this.orderDetail.loading = true
        await this.$axios({
          url: '/api/v1/orders/public/order-items/' + this.$route.params.order_id,
          method: 'GET',
        })
        .then(response => {
          console.log('response', response)
          if (response.status === 200) {
            this.orderDetail.data = response.data.data
          } else {
            throw new Error(response.data.message)
          }
        })
        .catch(error => {
          this.$store.dispatch('showSnackbar', {
            message: error,
            color: 'error'
          })
        })
        .finally(() => this.orderDetail.loading = false)
      }
    }
}
</script>

<style scoped>
.print-wrapper {
  padding: 12px;
  max-width: 600px;
}
.print-wrapper div p {
  font-size: 13px;
}
.print-wrapper .print-heading {
  margin-top: 18px;
  font-size: 1.5rem;
  font-family: "Belleza-Regular";
  text-decoration: none;
}
.logo {
  font-size: 2.5rem;
  font-family: "Belleza-Regular";
  text-decoration: none;
}
.d-flex {
  display: flex;
}
.flex-column {
  flex-direction: column;
}
.flex-grow-1 {
  flex-grow: 1 !important;
}
.order-table {
  border-collapse: collapse;
}
.order-table thead tr th {
  background: #c7c7c7;
  padding: 6px
}
.order-table tbody tr td {
  padding: 6px;
  border-bottom: 1px solid #333;
}
.order-table .total {
  text-align: right;
  font-weight: bold;
  border: none;
}
</style>