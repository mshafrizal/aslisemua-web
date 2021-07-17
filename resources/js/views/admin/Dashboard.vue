<template>
  <v-row>
    <v-col cols="12"><h3>Dashboard View</h3></v-col>
    <v-col cols="12" sm="4">
      <v-card>
        <v-card-title><h5>REGISTERED USERS</h5></v-card-title>
        <v-card-text>
          <span class="text-h4">921</span>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="4">
      <v-card>
        <v-card-title><h5>ORDERS COMPLETED</h5></v-card-title>
        <v-card-text>
          <span class="text-h4">129</span>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="4">
      <v-card style="height: 100%;">
        <v-card-title><h5>TOTAL REVENUE</h5></v-card-title>
        <v-card-text>
          <span class="text-h4">Rp 712.899.999</span>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" sm="9">
      <v-card>
        <v-card-title><h5>10 Latest Orders</h5></v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-simple-table class="eleveation-1">
            <template v-slot:default>
              <thead>
                <tr>
                  <th scope="col" class="text-left">Order ID</th>
                  <th scope="col" class="text-left">Products</th>
                  <th scope="col" class="text-left">Customer Name</th>
                  <th scope="col" class="text-left">Email</th>
                  <th scope="col" class="text-left">Phone</th>
                  <th scope="col" class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>2021040200001</td>
                  <td>Bottega Venetta Handbag, Hermes Scarves, Rolex Datejust</td>
                  <td>Jonathan Morningstar</td>
                  <td>jonathan.morningstar@gmail.com</td>
                  <td>08112992129</td>
                  <td>
                    <v-btn depressed small><v-icon left>mdi-eye</v-icon> Detail</v-btn>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'dashboard-page'
}
</script>

<style>

</style>
