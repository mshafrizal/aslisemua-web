<template>
  <v-app id="inspire">
    <v-snackbar-queue
      :items="snackbarItems"
      @remove="removeItem"
      close-button-icon="mdi-close"
      top
      next-button-count-text="More"
    ></v-snackbar-queue>
    <v-navigation-drawer v-if="renderDrawer" v-model="drawer" app width="215px">
      <v-list-item>
        <v-list-item-content><h1>Hi, Admin</h1></v-list-item-content>
      </v-list-item>

      <v-divider />
      <v-list dense nav>
        <template v-for="(menu, indexMenu) in menus">
          <v-list-group
            v-if="menu.children"
            :key="indexMenu"
            :value="true"
            :prepend-icon="menu.icon"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title v-text="menu.title">{{
                  menu.title
                }}</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list-item
              v-for="child in menu.children"
              :key="child.title"
              link
              :to="child.link"
            >
              <v-list-item-title v-text="child.title"></v-list-item-title>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="indexMenu" link :to="menu.link">
            <v-list-item-icon>
              <v-icon>{{ menu.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ menu.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon
        v-if="renderDrawer"
        @click="drawer = !drawer"
      ></v-app-bar-nav-icon>

      <v-toolbar-title>ASLISEMUA</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn @click="signOut" text>Logout</v-btn>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "AdminLayout",
  data: function() {
    return {
      drawer: true,
      menus: [
        {
          icon: "mdi-view-dashboard",
          title: "Dashboard",
          link: "/admin/dashboard"
        },
        {
          icon: "mdi-account-group",
          title: "Customers",
          link: "/admin/customer/list"
        },
        {
          icon: "mdi-cube-outline",
          title: "Master Data",
          children: [
            {
              title: "Brands",
              link: "/admin/brand/list"
            },
            {
              title: "Categories",
              link: "/admin/category/list"
            },
            {
              title: "Products",
              link: "/admin/product/list"
            },
            {
              title: "Regions",
              link: "/admin/region/list"
            },
            {
              title: "Payment Types",
              link: "/admin/payment-type/list"
            },
          ]
        },
        {
          icon: "mdi-currency-usd-circle-outline",
          title: "Orders",
          link: "/admin/order/list"
        },
        {
          icon: "mdi-account-cash",
          title: "Consignment",
          link: "/admin/consignment/list"
        }
      ]
    };
  },
  computed: {
    renderDrawer() {
      return this.$route.meta.requiresAuth;
    },
    snackbarItems() {
      return this.$store.getters.getSnackbar;
    }
  },
  methods: {
    removeItem(id) {
      this.$store.dispatch("removeSnackbarMessage", id);
    },
    signOut() {
      this.$store.dispatch("auth/authLogout");
      this.$router.push("/admin/signin").catch(err => {});
    }
  }
};
</script>

<style scoped></style>