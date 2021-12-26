<template>
  <v-row>
    <v-col cols="12"><h2>Region List</h2></v-col>
    <v-col cols="12" md="4">
      <h3>Province</h3>
      <province-list />
    </v-col>
    <v-col cols="12" md="4">
      <h3>City</h3>
      <city-list />
    </v-col>
    <v-col cols="12" md="4">
      <h3>District</h3>
      <district-list />
    </v-col>
  </v-row>
</template>

<script>
import ProvinceList from "./ProvinceList.vue";
import axios from "axios";
import CityList from './CityList.vue';
import DistrictList from './DistrictList.vue';
export default {
  name: "ProductList",
  components: {CityList, ProvinceList, DistrictList }
};
</script>

<style scoped></style>
