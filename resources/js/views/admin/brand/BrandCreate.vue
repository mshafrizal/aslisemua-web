<template>
  <v-dialog
    v-model="open"
    max-width="400"
  >
    <v-card>
      <v-card-title>Add New Brand</v-card-title>
      <v-form ref="formAddBrand" v-model="valid" @submit.prevent="handleSubmit">
        <v-card-text>
          <v-img
            max-height="297"
            max-width="500"
            :src="logoUrl"
          ></v-img>
          <v-file-input
            v-model="logo"
            clearable
            required
            :rules="requiredRules"
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
          <v-btn color="error" plain @click="close">Cancel</v-btn>
          <v-btn type="submit" :disabled="!valid" :loading="loading" color="primary" depressed>Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

</template>

<script>
export default {
  name: "BrandCreate",
  props: {
    open: Boolean
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
      status: false,
      valid: true
    }
  },
  computed: {
    logoUrl () {
      if (!this.logo) return
      return URL.createObjectURL(this.logo)
    }
  },
  watch: {
    open: function (val, oldVal) {
      this.logo = null
      this.name = ''
      this.loading = false
    }
  },
  methods: {
    close () {
      this.$emit('close')
    },
    handleSubmit () {
      if (this.$refs.formAddBrand.validate()) {
        this.loading = true
        let formData = new FormData()
        formData.append('file', this.logo, this.logo.name)
        formData.append('name', this.name)
        this.$store.dispatch('brand/createBrand', formData).then(result => {
          this.$store.dispatch('showSnackbar', {
            message: result.message,
            color: 'success'
          })
          this.close()
        }).catch(error => {
          console.log(error)
          this.$store.dispatch('showSnackbar', {
            message: error.response && error.response.data && error.response.data.message ? error.response.data.message : error.message,
            color: 'error'
          })
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$store.dispatch('showSnackbar', {
          message: 'Please check your form again',
          color: 'error'
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
