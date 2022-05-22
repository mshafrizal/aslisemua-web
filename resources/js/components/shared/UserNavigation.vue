<template>
  <v-container v-if="$route.meta.navbar">
    <v-row>
      <v-col class="hidden-sm-and-down"></v-col>
      <v-col class="hidden-sm-and-up">
        <v-btn @click.stop="drawer = !drawer" icon
          ><v-icon>mdi-menu</v-icon></v-btn
        >
      </v-col>
      <v-col class="text-center">
        <router-link class="black--text logo" to="/">ASLISEMUA</router-link>
      </v-col>
      <v-col class="hidden-sm-and-up"></v-col>
      <v-col class="justify-end hidden-sm-and-down">
        <v-row justify="end">
          <v-col cols="1">
            <v-btn icon><v-icon>mdi-heart-outline</v-icon></v-btn>
          </v-col>
          <v-col cols="1">
            <cart-button />
          </v-col>
          <v-col cols="1">
            <v-menu offset-y>
              <template v-slot:activator="{ on, attrs }">
                <v-btn v-bind="attrs" v-on="on" icon>
                  <v-icon>mdi-account-outline</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item
                  v-for="(item, index) in computedMenu"
                  :key="index"
                  :link="item.link !== null ? true : false"
                  :to="item.link !== null ? item.link : '#'"
                  @click="handleFunction(item.method)"
                >
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row class="hidden-sm-and-down">
      <v-col class="d-flex justify-center" v-if="categories.length > 0">
        <v-btn text small link to="/new-arrivals">New Arrivals</v-btn>
        <v-btn
          v-for="category in categories"
          :key="category.title"
          @click="handleLinkClick(category)"
          text
          small
        >
          {{ category.name }}
        </v-btn>
        <v-btn text small link color="error" to="/sale">Sale</v-btn>
        <v-btn text small color="warning">Sell With Us</v-btn>
      </v-col>
    </v-row>
    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list dense>
        <v-list-group>
          <template v-slot:activator>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>John Leider</v-list-item-title>
                <v-list-item-subtitle>john.leider@vue.org</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </template>

          <v-list-item link>
            <v-list-item-icon>
              <v-icon>mdi-heart-outline</v-icon>
            </v-list-item-icon>

            <v-list-item-title>Wishlist</v-list-item-title>
          </v-list-item>

          <v-list-item link>
            <v-list-item-icon>
              <v-icon>mdi-cart-outline</v-icon>
            </v-list-item-icon>

            <v-list-item-title>Cart</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item v-for="item in mobileMenus" :key="item.title" link>
          <v-list-item-icon v-if="item.icon">
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content :class="item.classes">
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="(item, index) in computedMenu"
          :key="index"
          :link="item.link !== null ? true : false"
          :to="item.link !== null ? item.link : '#'"
          @click="handleFunction(item.method)"
        >
          <v-list-item-icon
            ><v-icon>{{ item.icon }}</v-icon></v-list-item-icon
          >
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-container>
</template>

<script>
import CartButton from "./CartButton.vue";
export default {
  name: "UserNavigation",
  components: { CartButton },
  data: function() {
    return {
      drawer: false,
      userMenus: [
        {
          title: "Login",
          link: "/login",
          requiresAuth: false,
          method: null,
          icon: "mdi-login"
        },
        {
          title: "Register",
          link: "/register",
          requiresAuth: false,
          method: null,
          icon: "mdi-account-plus"
        },
        {
          title: "Profile",
          link: "/profile/detail",
          requiresAuth: true,
          method: null,
          icon: "mdi-account-outline"
        },
        {
          title: "Transactions",
          link: "/profile/transaction",
          requiresAuth: true,
          method: null,
          icon: "mdi-receipt"
        },
        {
          title: "Logout",
          link: null,
          requiresAuth: true,
          method: `logout`,
          icon: "mdi-logout"
        }
      ],
      mobileMenus: [
        { title: "New Arrivals", icon: false, classes: "" },
        { title: "Women", icon: false, classes: "" },
        { title: "Men", icon: false, classes: "" },
        { title: "Sale", icon: false, classes: "error--text" },
        { title: "Sell With Us", icon: false, classes: "warning--text" }
      ],
      categories: []
    };
  },
  computed: {
    computedMenu() {
      if (this.$store.getters["auth/authLoggedIn"] === true) {
        return this.userMenus.filter(menu => menu.requiresAuth);
      } else {
        return this.userMenus.filter(menu => !menu.requiresAuth);
      }
    }
  },
  created() {
    this.fetchCategories();
  },
  methods: {
    handleLinkClick(category) {
      this.$store.dispatch("filter/updateCategory", category);
      this.$router
        .push({
          name: "UserProducts",
          query: { c_name: category.name, c_id: category.id }
        })
        .catch(() => {});
    },
    handleFunction(function_name) {
      if (!function_name) return;
      this[function_name]();
    },
    logout() {
      this.$store.dispatch("auth/authLogout");
      this.$router.push("/login");
    },
    async fetchCategories() {
      const categories = await this.$store.dispatch(
        "category/fetchCategories",
        "main?limit=100"
      );
      if (categories.data && categories.data.length > 0) {
        this.categories = categories.data.filter(cat => cat.is_navbar > 0);
      }
    }
  }
};
</script>

<style scoped>
.logo {
  font-size: 2.5rem;
  font-family: "Belleza-Regular";
  text-decoration: none;
}
</style>
