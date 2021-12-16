<template>
  <v-container class="mb-10">
    <!-- <pre>{{JSON.stringify(this.$route.params, null, 2)}}</pre> -->
    <v-row class="mt-5 mb-5">
      <v-col cols="12" class="text-center">
        <h1 class="text-3xl">
          {{
            this.$route.query && this.$route.query.c_name
              ? this.$route.query.c_name
              : ""
          }}
        </h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="3">
        <v-card outlined class="relative">
          <v-card-text>
            <v-skeleton-loader v-if="categories.loading" type="list-item" />
            <categories-filter v-else :items="computedCategory" />
          </v-card-text>
          <v-divider />
          <v-card-text>
            <div class="text-lg font-weight-bold">Price Range</div>
            <v-text-field
              v-model="startPrice"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="From"
              class="mt-2"
            />
            <v-text-field
              v-model="endPrice"
              outlined
              dense
              hide-details
              single-line
              prefix="Rp"
              placeholder="To"
              class="mt-4"
            />
            <v-btn class="mt-2 black white--text" @click="fetchProducts" block
              >Apply</v-btn
            >
          </v-card-text>
          <v-divider />
          <v-card-text>
            <brands-filter :items="brands.data" />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12">
            <v-row>
              <v-col
                cols="3"
                offset-sm="6"
                class="text-right d-flex align-center justify-end"
              >
                Sort by price:
              </v-col>
              <v-col cols="3">
                <v-select
                  v-model="orderBy"
                  :items="sort.data"
                  item-text="text"
                  item-value="value"
                  outlined
                  hide-details
                  placeholder="Order By"
                  dense
                  @change="$store.dispatch('filter/fetchProductsByFilter')"
                ></v-select>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-divider class="mb-5"></v-divider>
            <v-skeleton-loader v-if="loading" type="card" class="mt-5">
            </v-skeleton-loader>
            <v-row v-if="products && !loading">
              <template v-for="(product, index) in products.data">
                <v-col cols="6" sm="4" md="3" :key="index">
                  <product-card :product="product" />
                </v-col>
              </template>
            </v-row>
            <v-divider class="my-5"></v-divider>
            <div class="d-flex justify-between">
              <v-btn icon outlined>
                <v-icon>mdi-chevron-left</v-icon>
              </v-btn>
              <v-btn icon outlined>
                <v-icon>mdi-chevron-right</v-icon>
              </v-btn>
            </div>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CategoriesFilter from "../../../components/shared/CategoriesFilter.vue";
import BrandsFilter from "../../../components/shared/BrandsFilter.vue";
import ProductCard from "../../../components/shared/ProductCard.vue";
export default {
  name: "UserProducts",
  components: { CategoriesFilter, BrandsFilter, ProductCard },
  data: function() {
    return {
      brands: {
        data: [],
        loading: true,
        selected: []
      },
      categories: {
        data: [],
        links: null,
        meta: null,
        loading: true,
        selected: null
      },
      sort: {
        data: [
          { value: "asc", text: "Low to High" },
          { value: "desc", text: "High to Low" }
        ],
        selected: "asc"
      },
      price: {
        start: 0,
        end: 0
      },
      keyword: ""
    };
  },
  async created() {
    this.categories.selected =
      this.$route.query && this.$route.query.c_name
        ? this.$route.query.c_name
        : "";
    await Promise.allSettled([this.fetchBrands(), this.fetchCategories()]).then(
      resutls => {
        resutls.forEach((result, index) => {
          if (result.status === "fulfilled") {
            if (index === 0) {
              this.fetchBrandsSuccess(result);
            }
            if (index === 1) {
              this.fetchCategoriesSuccess(result.value);
            }
          }
          if (result.status === "rejected") {
            this.$store.dispatch("showSnackbar", {
              message: result.reason.toString(),
              color: "error"
            });
          }
        });
      }
    );
    this.$store.dispatch("filter/fetchProductsByFilter");
  },
  computed: {
    search: {
      get() {
        return this.$store.getters["filter/getSearch"];
      },
      set(value) {
        this.$store.dispatch("filter/filter/updateSearch", value);
      }
    },
    orderBy: {
      get() {
        return this.$store.getters["filter/getOrderBy"];
      },
      set(value) {
        this.$store.dispatch("filter/updateOrderBy", value);
        this.fetchProducts();
      }
    },
    brand: {
      get() {
        return this.$store.getters["filter/getBrand"];
      },
      set(value) {
        this.$store.dispatch("filter/updateBrand", value);
        this.fetchProducts();
      }
    },
    category: {
      get() {
        return this.$store.getters["filter/getCategory"];
      },
      set(value) {
        this.$store.dispatch("filter/updateCategory", value);
        this.fetchProducts();
      }
    },
    startPrice: {
      get() {
        return this.$store.getters["filter/getStartPrice"];
      },
      set(value) {
        this.$store.dispatch("filter/updateStartPrice", value);
      }
    },
    endPrice: {
      get() {
        return this.$store.getters["filter/getEndPrice"];
      },
      set(value) {
        this.$store.dispatch("filter/updateEndPrice", value);
      }
    },
    products() {
      return this.$store.getters["filter/getResults"];
    },
    loading() {
      return this.$store.getters["filter/getLoading"];
    },
    computedCategory() {
      if (this.categories.data.length > 0) {
        return this.categories.data
          .map(cat => {
            return {
              ...cat,
              children: this.categories.data.filter(child => {
                return child.parent === cat.id;
              })
            };
          })
          .filter(cat => cat.parent === "null" || !cat.parent);
      }
      return [];
    }
  },
  methods: {
    fetchBrands() {
      return this.$store.dispatch("brand/fetchBrandsPublic");
    },
    fetchBrandsSuccess(result) {
      this.brands.loading = false;
      this.brands.data = result.value.results;
    },
    fetchCategories() {
      return this.$store.dispatch("category/fetchCategories", "main?limit=0");
    },
    fetchCategoriesSuccess(result) {
      this.categories.loading = false;
      this.categories.data = result.data;
      this.categories.links = result.links;
      this.categories.meta = result.meta;
    },
    async fetchProducts() {
      this.$store.dispatch("filter/fetchProductsByFilter");
    }
  }
};
</script>

<style></style>
