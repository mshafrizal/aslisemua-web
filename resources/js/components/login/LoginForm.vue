<template>
  <v-form v-model="valid" @submit.prevent="login" ref="loginForm" lazy-validation style="max-width: 400px; width: 100%">
    <v-sheet class="d-flex flex-column pa-4" max-width="400px" width="100%">
      <h1 class="text-3xl text-center mb-10">Welcome Back</h1>
      <div>Email</div>
      <v-text-field
        :dense="dense"
        id="email"
        v-model="email"
        placeholder="your@email.com"
        outlined
        type="email"
        autocomplete="email"
      />
      <div>Password</div>
      <v-text-field
        id="password"
        :dense="dense"
        v-model="password"
        placeholder="********"
        outlined
        :type="visible ? 'text' : 'password'"
        :append-icon="visible ? 'mdi-eye' : 'mdi-eye-off'"
        autocomplete="current-password"
        @click:append="visible = !visible"
      />
      <!--            <p class="text-caption">Forgot Password? <router-link to="/reset-password"><b>Click here</b></router-link></p>-->
      <v-btn color="black" class="white--text" type="submit" :loading="loading" block>Sign In</v-btn>
    </v-sheet>
  </v-form>
</template>

<script>
export default {
  name: "LoginForm",
  props: {
    dense: {
      required: false,
      type: Boolean,
      default: false
    }
  },
  data: function () {
    return {
      email: '',
      loading: false,
      password: '',
      valid: true,
      visible: false
    }
  },
  methods: {
    async login () {
      if (this.email.trim() === '' || this.password.trim() === '') {
        this.$store.dispatch('showSnackbar', {
          message: 'Email and password must be filled',
          type: 'error'
        })
        return false
      }
      this.loading = true
      this.$store.dispatch('auth/authLogin', { email: this.email, password: this.password, from: 'LoginForm.vue login()' }).then(result => {
        if (result && result.status === 200) {
          this.$store.dispatch('showSnackbar', {
            message: result.message,
            type: 'success'
          })
          this.$router.push({name: 'Homepage'})
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error,
          type: 'error'
        })
      }).finally(() => this.loading = false)
    }
  }
}
</script>

<style scoped>

</style>
