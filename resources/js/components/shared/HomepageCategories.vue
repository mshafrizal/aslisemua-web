<template>
  <v-row class="mt-5 mb-6 justify-center">
    <v-col cols=12 v-if="categories.loading">
      <v-container>
        <v-row>
          <v-col v-for="i in 6" :key="i" cols="6" sm="2">
            <v-skeleton-loader type="card" />
          </v-col>
        </v-row>
      </v-container>
    </v-col>
    <template v-else>
      <v-col
        v-for="category in categories.data"
        :key="category.id"
        cols="6"
        sm="4"
        md="2"
        @click="viewProductsByCategory(category.name, category.id)"
      >
        <v-img :src="category.file_path" :aspect-ratio="1/1" />
        <h4 class="text-center">{{category.name || '' }}</h4>
      </v-col>
      <v-col cols="12 text-center">
        <v-btn class="mx-auto white--text mt-5" color="black" depressed @click="$router.push('/all-categories')">See More Categories</v-btn>
      </v-col>
    </template>
  </v-row>
</template>

<script>
export default {
  name: "HomepageCategories",
  data: function () {
    return {
      categories: {
        data: [],
        loading: true
      }
    }
  },
  async created () {
    await this.getCategories()
  },
  methods: {
    viewProductsByCategory (name, id) {
      this.$router.push({ name: 'UserProducts', query: { c_name: name, c_id: id }})
    },
    getCategories () {
      this.categories.loading = true
      this.categories.data = []
      return this.$axios.get(`/api/v1/categories/public/main?limit=6`).then(response => {
        if (response.status === 200){
          this.categories.data = response.data.data
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
      }).finally(() => {
        this.categories.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
