<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" class="text-center mb-5 mt-5"><h1 class="text-3xl">All Categories</h1></v-col>
      <v-container v-if="categories.loading">
        <v-row>
          <v-col v-for="i in 6" :key="i" cols="6" sm="2">
            <v-skeleton-loader type="card" />
          </v-col>
        </v-row>
      </v-container>
      <v-col cols="12" v-else>
        <v-container>
          <v-row>
            <template v-for="(category, i) in categories.data">
              <v-col cols="6" sm="2" :key=i>
                <v-card class="elevation-0" @click="viewProductsByCategory(category.name, category.id)">
                  <v-img :src="category.file_path"></v-img>
                  <v-card-title class="text-center">
                    <h3 style="font-size: 18px; margin: 0 auto">{{ category.name }}</h3>
                  </v-card-title>
                </v-card>
              </v-col>
            </template>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'AllCategories',
  data: function () {
    return {
      categories: {
        loading: false,
        data: null
      }
    }
  },
  created () {
    this.fetchCategories()
  },
  methods: {
    viewProductsByCategory (name, id) {
      this.$router.push(`/products/${name}/${id}`)
    },
    fetchCategories () {
      this.categories.loading = true
      this.categories.data = null
      this.$store.dispatch('category/fetchCategories', 'main?limit=100').then(result => {
        this.categories.data = result.data
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      }).finally(() => {
        this.categories.loading = false
      })
    }
  }
}
</script>

<style>

</style>