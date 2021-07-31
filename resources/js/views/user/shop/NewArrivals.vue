<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h1 class="text-4xl my-5 text-center text-uppercase">New Arrivals</h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6">
        <v-card outlined class="relative">
          <div v-for="cat in computedCategories" :key="cat.id" @click="setSelectedParent(cat)">
            {{cat.name}}
          </div>
        </v-card>
        <v-card flat v-if="selectedParent">
          <div v-for="sub in selectedParent.children" :key="sub.id">
            {{ sub.name }}
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "NewArrivals",
  data: function () {
    return {
      categories: null,
      brands: [],
      selectedParent: null,
    }
  },
  beforeMount() {
    this.getCategories()
  },
  methods: {
    getCategories () {
      this.$store.dispatch('category/fetchCategories', 'main?limit=0').then(result => {
        if (result.status === 200) {
          this.categories = result
        } else {
          console.log(result)
        }
      })
    },
    setSelectedParent (cat) {
      this.selectedParent = cat
    }
  },
  computed: {
    computedCategories () {
      if (this.categories) {
        const parent = this.categories.data.filter(category => category.parent === 'null')
        parent.forEach(category => {
          category.children = this.categories.data.filter(sub => sub.parent === category.id)
        })
        return parent
      }
      return []
    }
  }
}
</script>

<style scoped>

</style>
