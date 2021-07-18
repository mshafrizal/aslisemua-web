<template>
  <v-container fill-height>
    <v-row>
      <transition name="fade" mode="out-in">
        <v-col cols="12" class="d-flex flex-col justify-center items-center" v-if="!submitSuccess">
          <h1 class="text-3xl text-center">Forgot Password?</h1>
          <p class="text-center mt-3">Enter your email address and we will send you a password reset link</p>
          <div class="border border-solid border-gray-900 p-3 mt-6 w-full" style="max-width: 400px">
            <v-form v-model="valid" ref="forgotPasswordForm" lazy-validation>
              <span>Email address</span>
              <v-text-field v-model="email" :rules="emailRules" color="black" outlined dense></v-text-field>
              <v-btn @click="submit" type="submit" color="black" :loading="loading" :disabled="!valid" depressed block class="white--text">REQUEST RESET LINK</v-btn>
            </v-form>
          </div>
        </v-col>
        <v-col cols="12" class="d-flex flex-col justify-center items-center" v-else>
          <h1 class="text-3xl text-center">Success!</h1>
          <p class="text-center mt-3">Reset password link has been sent to your email.</p>
        </v-col>
      </transition>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "ForgotPassword",
  data: function () {
    return {
      email: '',
      emailRules: [
        v => !!v || 'This field is required',
        v => v => /.+@.+\..+/.test(v) || 'E-mail invalid'
      ],
      loading: false,
      submitSuccess: false,
      submitSuccessMessage: '',
      valid: true
    }
  },
  methods: {
    submit (event) {
      event.preventDefault()
      this.loading = true
      this.$axios.post(`api/v1/forgot-password/email/send`, { email: this.email }).then(response => {
        if (response.status === 200) {
          this.submitSuccessMessage = response.data.message
          this.submitSuccess = true
        } else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: response.data?.message,
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
