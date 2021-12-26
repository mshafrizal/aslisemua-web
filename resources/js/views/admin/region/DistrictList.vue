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
        <tbody v-if="districts">
          <tr v-for="(district, index) in districts.data" :key="index">
            <td>{{ district.name }}</td>
            <td class="text-right">
              <v-btn color="warning" icon plain><v-icon>mdi-pencil</v-icon></v-btn>
              <v-btn color="error" icon plain><v-icon>mdi-trash-can</v-icon></v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <div class="d-flex flex-nowrap justify-between">
      <v-btn color="primary" icon plain :disabled="districts && !districts.prev_page_url" @click="prev">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-btn color="primary" icon plain :disabled="districts && !districts.next_page_url" @click="next">
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  name: "districtList",
  data: function () {
    return {
      districts: null,
      page: 1,
      search: "",
      loading: true,
    }
  },
  created () {
    this.getdistricts()
  },
  methods: {
    getdistricts () {
      this.loading = true
      return axios.get(`/api/v1/regions/public/district`).then(result => {
        this.districts = result.data.data
      }).catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to fetch districts",
          color: "error"
        })
      }).finally(() => {
        this.loading = false
      })
    },
    prev () {
        this.loading = true
        return axios.get(this.districts.prev_page_url).then(result => {
                this.districts = result.data.data
            }).catch(() => {
                this.$store.dispatch("showSnackbar", {
                message: "Failed to fetch districts",
                color: "error"
                })
            }).finally(() => {
            this.loading = false
        })
    },
    next () {
        this.loading = true
        return axios.get(this.districts.next_page_url).then(result => {
            this.districts = result.data.data
        }).catch(() => {
            this.$store.dispatch("showSnackbar", {
            message: "Failed to fetch districts",
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
