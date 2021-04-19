<template>
  <v-row>
    <v-col cols="12">Add Brand</v-col>
    <v-col cols="12" sm="4">
      <v-card>
        <v-form ref="formAddBrand" v-model="valid">
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
              hint="File size should be less than 2MB"
              show-size label="Brand Logo"
              prepend-icon="mdi-camera"
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Pick a logo"
            ></v-file-input>
            <v-divider></v-divider>
            <v-text-field v-model="name" label="Brand Name" required :rules="requiredRules"></v-text-field>
            <v-textarea v-model="description" label="Description"></v-textarea>
            <v-checkbox v-model="status" label="Active"></v-checkbox>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn color="error" plain>Cancel</v-btn>
            <v-btn :disabled="!valid" color="primary" depressed @click="handleSubmit">Submit</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "BrandCreate",
  data: function () {
    return {
      loading: false,
      logo: null,
      logoRules: [
        value => !value || value.size < 2000000 || 'Logo file size should be less than 2MB'
      ],
      requiredRules: [
        value => !!value || 'This field is required'
      ],
      name: '',
      description: '',
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
  mounted() {
    console.log(process.env.MIX_APP_URL)
  },
  methods: {
    handleSubmit () {
      if (this.$refs.formAddBrand.validate()) {
        let formData = new FormData()
        formData.append('file', this.logo, this.logo.name)
        formData.append('name', this.name)
        console.log(this.logo)
        console.log(this.logoUrl)
        console.log(formData.get('file'))
        this.$store.dispatch('brand/createBrand', formData).then(result => {
          console.log(result)
        }).catch(error => console.log(error))
      }
    }
  }
}
</script>

<style scoped>

</style>
