<template>
  <v-row>
    <v-col cols="12"><h3>Customer Detail</h3></v-col>
    <v-col cols="12" sm="3">
      <v-card>
        <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
        <v-card-text>
          <h4>{{ customer !== null && customer.name ? customer.name : '-' }}</h4>
          <v-row>
            <v-col cols="1"><v-icon :color="customer && customer.is_active ? 'success' : 'error'">mdi-record</v-icon></v-col>
            <v-col cols="10">{{ customer !== null && customer.is_active ? 'Active' : 'Banned' }}</v-col>
          </v-row>
          <v-row>
            <v-col cols="1"><v-icon>mdi-email-outline</v-icon></v-col>
            <v-col cols="10">{{ customer !== null && customer.email ? customer.email : '-' }}</v-col>
          </v-row>
          <v-row>
            <v-col cols="1"><v-icon>mdi-phone-outline</v-icon></v-col>
            <v-col cols="10">{{ customer !== null && customer.phone ? customer.phone : '-' }}</v-col>
          </v-row>
          <v-row>
            <v-col cols="1"><v-icon>{{ customer !== null && customer.gender === 'Male' ? 'mdi-gender-male' : 'mdi-gender-female' }}</v-icon></v-col>
            <v-col cols="10">{{ customer !== null && customer.gender ? customer.gender : '-' }}</v-col>
          </v-row>
          <v-row>
            <v-col cols="1"><v-icon>mdi-google-maps</v-icon></v-col>
            <v-col cols="10">{{ customer !== null && customer.address ? customer.address : '-' }}</v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="9">
      <v-card class="pa-3">
        <v-card-title>Transaction History ({{ customerTransactions.length }})</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <template v-for="(item, index) in customerTransactions">
            <v-card :key="index" class="elevation-0 mb-4" outlined>
              <v-card-title>{{item.order_date.toDateString()}}</v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                <v-row>
                  <v-col cols="12" sm="4">
                    <v-row>
                      <v-col cols="12">Transaction ID</v-col>
                      <v-col cols="12">{{item.id}}</v-col>
                    </v-row>
                  </v-col>
                  <v-col cols="12" sm="4">
                    <v-row>
                      <v-col cols="12">Status</v-col>
                      <v-col cols="12">{{item.order_status}}</v-col>
                    </v-row>
                  </v-col>
                  <v-col cols="12" sm="4">
                    <v-row>
                      <v-col cols="12">Total Purchases</v-col>
                      <v-col cols="12">Rp {{item.total_purchase.toLocaleString('id')}}</v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-text>
                <template v-for="(product, indexProduct) in item.products">
                  <v-row :key="indexProduct">
                    <v-col cols="12" sm="4">
                      <v-row>
                        <v-col cols="12">{{product.brand}}</v-col>
                        <v-col cols="12">{{product.name}}</v-col>
                      </v-row>
                    </v-col>
                    <v-col cols="12" sm="4">
                      <v-row>
                        <v-col cols="12">Price</v-col>
                        <v-col cols="12">{{product.price}}</v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                  <v-divider class="my-3" v-if="indexProduct+1 !== item.products.length"></v-divider>
                </template>
              </v-card-text>
            </v-card>
          </template>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'customer-detail',
  data: function () {
    return {
      customer: null,
      customerTransactions: [
        {
          id: 'INV/20210101/0000001',
          order_status: 'processed',
          total_purchase: 47950000,
          order_date: new Date,
          products: [
            {
              id: '2917834',
              brand: 'Cartier',
              name: 'Guilloche Amulette De Cartier Ring',
              price: 37950000
            },
            {
              id: '2917812',
              brand: 'The Row',
              name: 'Sabot Leather Mules',
              price: 10000000
            }
          ]
        },
        {
          id: 'INV/20200131/0000001',
          order_status: 'completed',
          total_purchase: 15750000,
          order_date: new Date,
          products: [
            {
              id: '125639',
              brand: 'Prada',
              name: 'Crocodile-Trimmed Skipper Bag',
              price: 7000000
            },
            {
              id: '712371',
              brand: 'Tory Burch',
              name: 'Wool Scarf',
              price: 8750000
            }
          ]
        }
      ]
    }
  },
  mounted () {
    this.fetchCustomerDetail()
  },
  methods: {
    fetchCustomerDetail () {
      this.$set(this, 'customer', {
        name: 'Jonathan Morningstar',
        email: 'jonathan@gmail.com',
        gender: 'Male',
        phone: '08123881262',
        address: 'Komplek Sandang Jalan U Nomor 38A, Palmerah, Jakarta Barat 11480',
        is_active: true
      })
    }
  }
}
</script>

<style>

</style>
