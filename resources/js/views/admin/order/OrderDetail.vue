<template>
  <v-row>
      <v-col cols="12">
          <h2>Brands</h2>
      </v-col>
      <v-col cols="12">
          <v-card>
              <v-card-title>
                  ORDER INFO
              </v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                  <v-col cols="4">
                      <strong>Order ID</strong>
                  </v-col>
                  <v-col cols="8">
                      
                  </v-col>
              </v-card-text>
          </v-card>
      </v-col>
  </v-row>
</template>

<script>
export default {
    name: 'OrderDetail',
    data: function () {
        return {
            order: null,
            loading: true,
        }
    }
}
</script>

<style>

</style>