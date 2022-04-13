<template>
  <v-row justify="center">
    <v-col cols="12" md="6">
      <v-card :loading="loading || isSubmitting">
        <template slot="progress">
          <v-progress-linear
            color="black"
            height="5"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-skeleton-loader
          type="article, actions"
          v-if="loading"
        ></v-skeleton-loader>
        <v-card-text v-if="!loading && personalInfo">
          <v-row dense>
            <v-col cols="12" md="6">
              <span>Name</span>
              <v-text-field v-model="personalInfo.name" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>Email</span>
              <v-text-field v-model="personalInfo.email" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>Gender</span>
              <v-text-field v-model="personalInfo.gender" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>Phone Number</span>
              <v-text-field v-model="personalInfo.phone_number" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>Postal Code</span>
              <v-text-field v-model="personalInfo.postal_code" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>City</span>
              <v-text-field v-model="personalInfo.city" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <span>District</span>
              <v-text-field v-model="personalInfo.district" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12">
              <span>Address</span>
              <v-textarea v-model="personalInfo.address" color="black" :disabled="!isEditing" :hide-details="!isEditing" outlined></v-textarea>
            </v-col>
           <!-- <v-col cols="12">
             <v-btn v-if="!isEditing" @click="isEditing = !isEditing" color="black" outlined block>Edit</v-btn>
           </v-col> -->
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "PersonalInfo",
  data: function () {
    return {
      isEditing: false,
      isSubmitting: false,
      loading: false,
      password: '',
      personalInfo: null
    }
  },
  beforeMount() {
    this.getPersonalInfo()
  },
  methods: {
    getPersonalInfo () {
      const { id } = JSON.parse(this.$store.getters['auth/authUserInfo'])
      this.$axios.get(`/api/v1/customers/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      }).then(response => {
        if (response.status === 200 && response.data.data) {
          this.personalInfo = response.data.data
        } else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: response.data.message,
            type: 'error'
          })
        }
      }).catch(error => {
        if (error.response) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.response.data.message,
            type: 'error'
          })
        } else if (error.request) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.request.toString(),
            type: 'error'
          })
        } else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.message.toString(),
            type: 'error'
          })
        }
      }).finally(() => this.loading = false)
    }
  }
}
</script>

<style scoped>

</style>
