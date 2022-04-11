<template>
  <div>
    <v-simple-table>
      <template v-slot:default>
        <thead>
        <tr>
          <th class="text-left">
            Name
          </th>
          <th class="text-right">
            Actions
          </th>
        </tr>
        </thead>
        <tbody v-if="cities">
          <tr v-for="(city, index) in cities.data" :key="index">
            <td>{{ city.name }}</td>
            <td class="text-right">
              <v-btn color="warning" icon plain><v-icon>mdi-pencil</v-icon></v-btn>
              <v-btn color="error" icon plain><v-icon>mdi-trash-can</v-icon></v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <div class="d-flex flex-nowrap justify-between">
      <v-btn color="primary" icon plain :disabled="cities && !cities.prev_page_url" @click="prev">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-btn color="primary" icon plain :disabled="cities && !cities.next_page_url" @click="next">
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  name: "CityList",
  data: function () {
    return {
      cities: null,
      page: 1,
      search: "",
      loading: true,
    }
  },
  created () {
    this.getcities()
  },
  methods: {
    getcities () {
      this.loading = true
      return axios.get(`/api/v1/regions/public/city`).then(result => {
        this.cities = result.data.data
      }).catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to fetch cities",
          color: "error"
        })
      }).finally(() => {
        this.loading = false
      })
    },
    prev () {
        this.loading = true
        return axios.get(this.cities.prev_page_url).then(result => {
                this.cities = result.data.data
            }).catch(() => {
                this.$store.dispatch("showSnackbar", {
                message: "Failed to fetch cities",
                color: "error"
                })
            }).finally(() => {
            this.loading = false
        })
    },
    next () {
        this.loading = true
        return axios.get(this.cities.next_page_url).then(result => {
            this.cities = result.data.data
        }).catch(() => {
            this.$store.dispatch("showSnackbar", {
            message: "Failed to fetch cities",
            color: "error"
            })
        }).finally(() => {
        this.loading = false
      })
    }
  }
};
</script>

<style></style>
