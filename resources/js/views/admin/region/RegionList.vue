<template>
  <v-row>
    <v-col cols="12"><h2>Region List</h2></v-col>
    <v-col cols="12" md="4">
      <province-list />
    </v-col>
    <v-col cols="12" md="4">
      <div class="d-flex justify-space-between">
        <h3>City</h3>
        <v-btn icon><v-icon>mdi-plus</v-icon></v-btn>
      </div>
      <city-list />
    </v-col>
    <v-col cols="12" md="4">
      <div class="d-flex justify-space-between">
        <h3>District</h3>
        <v-btn icon><v-icon>mdi-plus</v-icon></v-btn>
      </div>
      <district-list />
    </v-col>
  </v-row>
</template>

<script>
import ProvinceList from "./ProvinceList.vue";
import CityList from './CityList.vue';
import DistrictList from './DistrictList.vue';
export default {
  name: "ProductList",
  components: {CityList, ProvinceList, DistrictList }
};
</script>
