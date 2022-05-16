<template>
  <div class="d-flex flex-column">
    <div class="text-lg font-weight-bold mb-2">Brands</div>
    <div class="d-flex flex-column">
      <template v-for="brand in items">
        <v-checkbox
          v-model="selectedBrand"
          :key="brand.id"
          :label="brand.name"
          hide-details
          :value="brand.name"
          dense
          color="black"
          @change="handleChange"
        />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: "BrandsFilter",
  props: ["items"],
  data: function() {
    return {
      selected: []
    };
  },
  methods: {
    handleChange(val) {
      this.$emit("brand-selected", val);
    }
  },
  computed: {
    selectedBrand: {
      get() {
        return this.$store.getters["filter/getBrand"];
      },
      set(value) {
        this.$store.dispatch("filter/updateBrand", value);
        this.$store.dispatch("filter/fetchProductsByFilter");
      }
    }
  }
};
</script>

<style></style>
