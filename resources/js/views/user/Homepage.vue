<template>
  <v-container>
    <v-dialog v-model="isDisplayed" persistent max-width="300">
      <v-card>
        <v-card-title class="logo justify-center">ASLISEMUA</v-card-title>
        <v-divider></v-divider>
        <v-card-text class="pa-0">
          <login-form :dense="true" />
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-carousel
      class="mt-10"
      height="500"
      cycle
      hide-delimiter-background
      show-arrows-on-hover
    >
      <v-carousel-item
        v-for="(slide, i) in slides"
        :key="i"
        :src="slide"
      >
      </v-carousel-item>
    </v-carousel>

    <v-img class="my-16" src="/images/SALE BANNER.svg" />

    <h1 class="text-3xl text-center m-10">CATEGORIES</h1>

    <homepage-categories />

    <homepage-new-arrivals />
  </v-container>
</template>

<script>
import HomepageCategories from "../../components/shared/HomepageCategories";
import HomepageNewArrivals from "../../components/shared/HomepageNewArrivals";
import LoginForm from '../../components/login/LoginForm'
export default {
  name: "Homepage",
  components: {HomepageNewArrivals, HomepageCategories, LoginForm},
  data: function () {
    return {
      colors: [
        'indigo',
        'warning',
        'pink darken-2',
        'red lighten-1',
        'deep-purple accent-4',
      ],
      slides: [
        '/images/carousel-1.jpg',
        '/images/carousel-2.jpg',
        '/images/carousel-3.jpg'
      ],
      isDisplayed: false
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
