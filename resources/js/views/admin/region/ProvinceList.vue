<template>
  <div>
    <v-dialog v-model="open.edit">
      <v-card>
        <v-card-title>
          Edit Province
        </v-card-title>
        <v-form ref="formEditProvince" v-model="form.valid">
          <v-card-text>
            <v-text-field v-model="form.name" :rules="[v => !!v || 'This field is required']"></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-btn color="error" @click="closeDialog" :disabled="isSubmitting">Cancel</v-btn>
            <v-btn color="primary" :loading="isSubmitting" :disabled="!form.valid" @click="submit">Submit</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
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
        <tbody v-if="provinces">
          <tr v-for="(province, index) in provinces.data" :key="index">
            <td>{{ province.name }}</td>
            <td class="text-right">
              <v-btn color="warning" icon plain @click="openDialog(province)"><v-icon>mdi-pencil</v-icon></v-btn>
              <v-btn color="error" icon plain><v-icon>mdi-trash-can</v-icon></v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <div class="d-flex flex-nowrap justify-between">
      <v-btn color="primary" icon plain :disabled="provinces && !provinces.prev_page_url" @click="prev">
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-btn color="primary" icon plain :disabled="provinces && !provinces.next_page_url" @click="next">
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProvinceList",
  data: function () {
    return {
      provinces: null,
      page: 1,
      search: "",
      loading: true,
      form: {
        valid: true,
        id: '',
        name: '',
      },
      isSubmitting: false,
      open: {
        edit: false,
        delete: false,
      },
    }
  },
  created () {
    this.getProvinces()
  },
  methods: {
    getProvinces () {
      this.loading = true
      return axios.get(`/api/v1/regions/public/province`).then(result => {
        this.provinces = result.data.data
      }).catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to fetch provinces",
          color: "error"
        })
      }).finally(() => {
        this.loading = false
      })
    },
    prev () {
        this.loading = true
        return axios.get(this.provinces.prev_page_url).then(result => {
                this.provinces = result.data.data
            }).catch(() => {
                this.$store.dispatch("showSnackbar", {
                message: "Failed to fetch provinces",
                color: "error"
                })
            }).finally(() => {
            this.loading = false
        })
    },
    next () {
        this.loading = true
        return axios.get(this.provinces.next_page_url).then(result => {
            this.provinces = result.data.data
        }).catch(() => {
            this.$store.dispatch("showSnackbar", {
            message: "Failed to fetch provinces",
            color: "error"
            })
        }).finally(() => {
        this.loading = false
      })
    },
    openDialog (mode, province) {
      this.open[mode] = true
      this.form.name = province.name
      this.form.id = province.id
    },
    closeDialog () {
      this.open.edit = false
      this.open.delete = false
      this.form.name = ''
      this.form.id = ''
      this.form.valid = true
    },
    submit () {
      const params = {
        name: this.form.name
      }
      this.isSubmitting = true
      return axios.post(`/api/v1/regions/private/province`, params).then(response => {
        if (response.status === 200) {
          this.$store.dispatch("showSnackbar", {
            message: "Success update province",
            color: "success"
          })
        }
      }).catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to update province",
          color: "error"
        })
      }).finally(() => {
        this.isSubmitting = false
      })
    }
  }
};
</script>

<style></style>
