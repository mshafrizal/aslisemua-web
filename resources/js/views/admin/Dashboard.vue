<template>
  <v-row justify="center">
    <v-col cols="12">
      <h1 class="text-center">Selamat Datang</h1>
      <p class="text-center">Quick Menu</p>
    </v-col>
    <v-col cols="4">
      <div class="d-flex flex-column">
        <v-btn depressed large class="mb-4" :to="{ name: 'customer-list' }">Users</v-btn>
        <v-btn depressed large class="mb-4" :to="{ name: 'product-list' }">Products</v-btn>
        <v-btn depressed large class="mb-4" :to="{ name: 'order-list' }">Orders</v-btn>
      </div>
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
