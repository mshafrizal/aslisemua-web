<template>
  <v-row class="mt-5 mb-6 justify-center" v-if="categories">
    <v-col
      v-for="category in categories"
      :key="category.id"
      cols="6"
      sm="4"
      md="2"
      @click="toDemoPage(category)"
    >
      <!-- <v-img :src="resolveImagePath(category.file_path)" :aspect-ratio="1/1" /> -->
      <v-img :src="category.file_path" :aspect-ratio="1/1" />
      <h4 class="text-center">{{category.name || '' }}</h4>
    </v-col>
    <v-col cols="12 text-center">
      <v-btn class="mx-auto white--text mt-5" color="black" depressed>See More Categories</v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "HomepageCategories",
  data: function () {
    return {
      categories: [
        {
          id: 1,
          name: 'Men\'s',
          file_path: '/images/dummyProduct/cat-men.jpg'
        },
        {
          id: 2,
          name: 'Women\'s',
          file_path: '/images/dummyProduct/cat-women.jpg'
        },
        {
          id: 3,
          name: 'Bag\'s',
          file_path: '/images/dummyProduct/cat-bag.jpg'
        },
        {
          id: 4,
          name: 'Watches',
          file_path: '/images/dummyProduct/cat-watch.jpg'
        },
        {
          id: 5,
          name: 'Jewelry',
          file_path: '/images/dummyProduct/cat-jewelry.jpg'
        },
        {
          id: 6,
          name: 'Kid\'s',
          file_path: '/images/dummyProduct/cat-kids.jpg'
        },
      ]
    }
  },
  async created () {
    // await this.getCategories()
  },
  methods: {
    getCategories () {
      return this.$axios.get(`${process.env.MIX_APP_URL}/api/v1/categories/public/main?limit=0`).then(response => {
        if (response.status === 200){
          this.categories = response.data.data
        }
      }).catch(error => {
        let message = ''
        if (error.response) message = error.response.data.message
        else if (error.request) message = 'Something went wrong, please contact admin'
        else message = error.message
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: message,
          type: 'error'
        })
      })
    },
    resolveImagePath (path) {
      return '../storage/' + path
    },
    toDemoPage(cat) {
      this.$router.push(`/demo/shop/${cat.id}/${cat.name}`)
    }
  }
}
</script>

<style scoped>

</style>
