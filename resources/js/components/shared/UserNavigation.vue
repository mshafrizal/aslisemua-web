<template>
  <v-container v-if="$route.meta.navbar">
    <v-row>
      <v-col></v-col>
      <v-col>
        <h1 class="text-center logo">ASLISEMUA</h1>
      </v-col>
      <v-col class="d-flex justify-end">
        <v-btn icon><v-icon>mdi-heart-outline</v-icon></v-btn>
        <v-btn icon><v-icon>mdi-cart-outline</v-icon></v-btn>
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              icon
            >
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
    <v-row>
      <v-col class="d-flex justify-center">
        <v-btn text small>New Arrivals</v-btn>
        <v-btn text small>Women</v-btn>
        <v-btn text small>Men</v-btn>
        <v-btn text small color="error">Sale</v-btn>
        <v-btn text small color="warning">Sell With Us</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "UserNavigation",
   data: function () {
     return {
       userMenus: [
         {title: 'Login', link: '/login', requiresAuth: false, method: null},
         {title: 'Register', link: '/register', requiresAuth: false, method: null},
         {title: 'Profile', link: '/profile', requiresAuth: true, method: null},
         {title: 'Transactions', link: '/profile/transaction-history', requiresAuth: true, method: null},
         {title: 'Logout', link: null, requiresAuth: true, method: `$store.dispatch('auth/authLogout')`}
       ]
     }
   },
  computed: {
    computedMenu () {
      if (this.$store.getters['auth/authLoggedIn'] === true) {
        return this.userMenus.filter(menu => menu.requiresAuth)
      } else {
        return this.userMenus.filter(menu => !menu.requiresAuth)
      }
    }
  },
  methods: {
    handleFunction (function_name) {
      if (!function_name) return
      this[function_name]()
    }
  }
}
</script>

<style scoped>
  .logo {
    font-size: 2.5rem;
    font-family: 'Belleza-Regular';
  }
</style>
