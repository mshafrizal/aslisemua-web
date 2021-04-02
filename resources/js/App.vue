<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list-item>
        <v-list-item-content><h1>Hi, Admin</h1></v-list-item-content>
      </v-list-item>
      
      <v-divider />
      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="menu in menus"
          :key="menu.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ menu.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ menu.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>ASLISEMUA</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  components: {
    'sidebar-component': Sidebar,
    'header-component': Header
  },
  data: function () {
    return {
      drawer: true,
      menus: [
        {
          icon: 'mdi-view-dashboard',
          title: 'Dashboard'
        },
        {
          icon: 'mdi-view-dashboard',
          title: 'Customer'
        },
        {
          icon: 'mdi-view-dashboard',
          title: 'Product'
        },
        {
          icon: 'mdi-view-dashboard',
          title: 'Order'
        },
      ]
    }
  },
  mounted () {
    console.log(this.$route)
  }
}
</script>

<style>

</style>