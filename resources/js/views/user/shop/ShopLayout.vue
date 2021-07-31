<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h1 class="text-3xl">{{ $route.name }}</h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="2"></v-col>
      <v-col cols="12" sm="10">
        <router-view></router-view>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "ShopLayout"
}
</script>

<style scoped>

</style>
