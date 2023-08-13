<template>
  <v-dialog
    v-model="open"
    max-width="400"
    persistent
  >
    <v-card v-if="loading">
      <v-skeleton-loader
        class="mx-auto"
        max-width="400"
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-card v-else>
      <v-form ref="formCreateProvince" v-model="valid" @submit.prevent="handleSubmit">
        <v-card-title>Add Province</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-text-field
            v-model.trim="name"
            :rules="nameRules"
            label="Name"
            name="name"
            required
          ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="error" text :disabled="loading" @click="close">Cancel</v-btn>
          <v-btn color="primary" depressed :disabled="!valid" :loading="isSubmitting" type="submit">Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "ProvinceCreate",
  props: {
    open: Boolean
  },
  watch: {
    open(val) {
      if (val) this.reset();
    }
  },
  data: function () {
    return {
      isSubmitting: false,
      valid: true,
      name: '',
      loading: false,
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length > 3) || 'Name must be more than 3 characters',
      ],
    }
  },
  methods: {
    close () {
      this.name = ''
      this.$emit('close')
    },
    handleSubmit () {
      this.isSubmitting = true
      const params = {
        name: this.name
      }
      return axios.post(`/api/v1/regions/private/province`, params).then(() => {
        this.$store.dispatch("showSnackbar", {
          value: true,
          message: "Success update province",
          color: "success"
        })
        this.$emit("saved")
      }).catch(error => {
        console.log(error);
        this.$store.dispatch("showSnackbar", {
          value: true,
          message: "Failed to create province",
          color: "error"
        })
      }).finally(() => {
        this.isSubmitting = false
        this.name = ''
        this.close()
      })
    },
    reset () {
      this.$refs.formCreateProvince?.reset()
    },
  }
}
</script>
