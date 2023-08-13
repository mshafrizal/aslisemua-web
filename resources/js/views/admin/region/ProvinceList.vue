<template>
  <div>
    <div class="d-flex justify-space-between">
      <h3>Province</h3>
      <v-btn @click="open.create = true" icon><v-icon>mdi-plus</v-icon></v-btn>
    </div>
    <province-create :open="open.create" @close="open.create = false" @saved="getProvinces" />
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
    <v-dialog v-model="open.delete" max-width="400">
      <v-card>
        <v-card-title>
          Delete Province
        </v-card-title>
        <v-card-text>
          <p>Are you sure to delete {{ form.name }}?</p>
        </v-card-text>
        <v-card-actions>
          <v-btn color="error" @click="closeDialog" :disabled="isSubmitting">No</v-btn>
          <v-btn color="primary" :loading="isSubmitting" @click="onDelete">Yes</v-btn>
        </v-card-actions>
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
              <v-btn color="warning" icon plain @click="openDialog('edit', province)"><v-icon>mdi-pencil</v-icon></v-btn>
              <v-btn color="error" icon plain @click="openDialog('delete', province)"><v-icon>mdi-trash-can</v-icon></v-btn>
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
import ProvinceCreate from './ProvinceCreate.vue';
export default {
  name: "ProvinceList",
  components: { ProvinceCreate },
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
        create: false,
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
      return axios.put(`/api/v1/regions/private/province/${this.form.id}`, params).then(response => {
        if (response.status === 200) {
          this.$store.dispatch("showSnackbar", {
            message: "Success update province",
            color: "success"
          })
        }
      })
      .then(() => this.getProvinces())
      .catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to update province",
          color: "error"
        })
      }).finally(() => {
        this.isSubmitting = false
        this.closeDialog();
      })
    },
    onDelete () {
      this.isSubmitting = true;
      return axios.delete(`/api/v1/regions/private/province/${this.form.id}`).then(response => {
        this.$store.dispatch("showSnackbar", {
          message: "Success update province",
          color: "success"
        })
      })
      .then(() => this.getProvinces())
      .catch(() => {
        this.$store.dispatch("showSnackbar", {
          message: "Failed to delete province",
          color: "error"
        })
      }).finally(() => {
        this.isSubmitting = false
        this.closeDialog();
      })
    }
  }
};
</script>
