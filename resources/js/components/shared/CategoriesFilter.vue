<template>
  <div>
    <div
      class="text-lg font-weight-bold mb-3 cursor-pointer"
      @click="toAllProducts"
    >
      All Categories
    </div>
    <div class="d-flex flex-col">
      <ul class="pl-2">
        <li v-for="item in items" :key="item.id">
          <div
            v-if="item.children.length === 0"
            :class="{
              'black--text category__item': true,
              'category--active': category.id === item.id
            }"
            @click="selectCategory(item)"
          >
            {{ item.name }}
          </div>
          <div class="d-flex flex-col" v-else>
            <div
              @click="selectCategory(item)"
              :class="{
                'black--text category__item': true,
                'category--active': category.id === item.id
              }"
            >
              {{ item.name }}
            </div>
            <ul class="pl-2">
              <li v-for="child in item.children" :key="child.id">
                <div
                  @click="selectCategory(child)"
                  :class="{
                    'black--text category__item': true,
                    'category--active': category.id === child.id
                  }"
                >
                  {{ child.name }}
                </div>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "CategoriesFilter",
  props: ["items"],
  data: function() {
    return {
      categories: {
        active: [],
        selected: null
      }
    };
  },
  computed: {
    category: {
      get() {
        return this.$store.getters["filter/getCategory"];
      },
      set(value) {
        this.$store.commit("updateCategory", value);
        // this.fetchProducts()
      }
    }
  },
  mounted() {
    // if (this.$route.query.c_id) {
    //   this.categories.selected = this.$route.query.c_id;
    // }
  },
  methods: {
    toAllProducts() {
      this.$store.dispatch("filter/updateCategory", "");
      this.$store.dispatch("filter/fetchProductsByFilter");
    },
    selectCategory(item) {
      this.$store.dispatch("filter/updateCategory", item);
      this.$emit("selected", item);
      this.$store.dispatch("filter/fetchProductsByFilter");
    },
    getActiveValue(val) {
      this.$emit("selected", val[0]);
    }
  }
};
</script>

<style scoped>
.category__item {
  padding: 8px 12px;
}
.category__item:hover {
  background-color: #fafafa;
}
.category__item.category--active {
  background-color: #e6e6e6;
}
</style>
