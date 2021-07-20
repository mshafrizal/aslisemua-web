<template>
  <v-card outlined class="mb-4">
    <v-card-title>01 Jan 2021</v-card-title>
    <v-divider />
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="6" class="d-flex flex-col">
          <div>Transaction ID</div>
          <div>INV/20210101/0000001</div>
        </v-col>
        <v-col cols="12" sm="3" class="d-flex flex-col">
          <div>Status</div>
          <div class="text-green-400 font-bold">Order Processed</div>
        </v-col>
        <v-col cols="12" sm="3" class="d-flex flex-col">
          <div>Total Purchases</div>
          <div class="text-yellow-500">Rp 47.950.000</div>
        </v-col>
      </v-row>
    </v-card-text>
    <v-divider />
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="6" class="d-flex flex-col">
          <div class="font-bold">Cartier</div>
          <div>Guilloche Amulette De Cartier Ring</div>
        </v-col>
        <v-col cols="12" sm="3" class="d-flex flex-col">
          <div>Price</div>
          <div class="text-yellow-500">Rp 37.950.000</div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: "MyPurchases"
}
</script>

<style scoped>

</style>
