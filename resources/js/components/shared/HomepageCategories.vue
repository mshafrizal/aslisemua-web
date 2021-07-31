<template>
  <v-row class="mt-5 mb-6 justify-center">
    <v-col
      v-for="category in categories"
      :key="category.id"
      cols="6"
      sm="4"
      md="2"
    >
      <v-img :src="resolveImagePath(category.file_path)" :aspect-ratio="1/1" />
      <h4 class="text-center">{{category.name || '' }}</h4>
    </v-col>
    <v-btn class="mx-auto white--text mt-5" color="black" depressed>See More Categories</v-btn>
  </v-row>
</template>

<script>
export default {
  name: "HomepageCategories",
  data: function () {
    return {
      categories: null
    }
  },
  async created () {
    await this.getCategories()
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
    }
  }
}
</script>

<style scoped>

</style>
