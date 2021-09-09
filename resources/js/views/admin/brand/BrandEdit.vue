<template>
  <v-dialog
    v-model="open"
    max-width="400"
    persistent
  >
    <v-card v-if="!brandForm.data">
      <v-skeleton-loader
        class="mx-auto"
        max-width="400"
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-card v-else>
      <v-card-title>Edit Brand</v-card-title>
      <v-form ref="formEditBrand" v-model="valid" @submit.prevent="handleSubmit">
        <v-card-text>
          <v-img
            max-height="297"
            max-width="500"
            :src="logoUrl"
          ></v-img>
          <v-file-input
            v-model="logo"
            clearable
            show-size label="Brand Logo"
            prepend-icon="mdi-camera"
            accept="image/png, image/jpeg, image/bmp"
            placeholder="Pick a logo"
          ></v-file-input>
          <v-divider></v-divider>
          <v-text-field v-model="name" label="Brand Name" required :rules="requiredRules"></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="error" plain :disabled="loading" @click="close(false)">Cancel</v-btn>
          <v-btn :loading="loading" :disabled="!valid" color="primary" depressed type="submit">Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "BrandEdit",
  props: {
    open: Boolean,
    brandId: String
  },
  data: function () {
    return {
      loading: false,
      logo: null,
      logoRules: [
        value => !value || value.size < 2000000 || 'Logo file size should be less than 2MB'
      ],
      requiredRules: [
        value => !!value || 'This field is required',
      ],
      name: '',
      description: '',
      status: false,
      valid: true,
      brandForm: {
        data: null,
        isSubmitting: false,
      }
    }
  },
  computed: {
    logoUrl () {
      if (!this.logo) return this.brandForm.data ? this.brandForm.data.file_path : null
      return URL.createObjectURL(this.logo)
    }
  },
  watch: {
    open: function (val, oldVal) {
      if (val === true) {
        this.getBrand(this.brandId)
      } else {
        this.brandForm.data = null
        this.isSubmitting = false
        this.loading = false
        this.logo = null
        this.name = ''
      }
    }
  },
  methods: {
    close (reload) {
      this.$emit('close', { value: reload })
    },
    getBrand (id) {
      this.loading = true
      this.$store.dispatch('brand/fetchBrand', { brand_id: id }).then(result => {
        this.brandForm.data = result.results
        this.name = result.results.name
        this.description = result.results.description
        this.status = result.results.status ? true : false
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.response ? error.response.message : error.message,
          color: 'error'
        })
        this.brandForm.data = null
        this.close()
      }).finally(() => {
        this.loading = false
      })
    },
    handleSubmit () {
      if (this.$refs.formEditBrand.validate()) {
        this.loading = true
        let formData = new FormData()
        if (this.logo) {
          formData.append('file', this.logo, this.logo.name)
        }
        formData.append('name', this.name)
        this.$store.dispatch('brand/updateBrand', { brand_id: this.brandId, data: formData}).then(result => {
          if (result.status >= 400) throw new Error(result.message)
          this.$store.dispatch('showSnackbar', {

            message: result.message,
            color: 'success'
          })
        }).catch(error => {
          this.$store.dispatch('showSnackbar', {

            message: error,
            color: 'error'
          })
        }).finally(() => {
          this.loading = false
          this.close(true)
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
