<template>
  <v-row>
    <v-col cols="12" sm="10">Brand List</v-col>
    <v-col cols="12" sm="2">
      <v-btn href="/admin/brands/create" block>Add Brand</v-btn>
    </v-col>
    <v-col cols="12">
      <v-data-table :loading="loading" class="elevation-1"></v-data-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "BrandList",
  data: function () {
    return {
      loading: true,
      dataBrands: []
    }
  }
}
</script>

<style scoped>

</style>
