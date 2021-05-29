<template>
  <v-row class="justify-center">
    <v-col cols="12" class="text-center">
      <h1>ADMIN ASLISEMUA</h1>
      <p>Login</p>
    </v-col>
    <v-col cols="12" sm="3">
      <v-card>
        <v-card-text>
          <v-form ref="formLogin" lazy-validation>
            <v-text-field
              label="Email"
              placeholder="youremail@email.com"
              v-model="formLogin.email"
              type="email"
              :rules="rulesEmail"
            ></v-text-field>
            <v-text-field
              label="Password"
              placeholder="********"
              v-model="formLogin.password"
              type="password"
              :rules="rulesPassword"
            >
            </v-text-field>
            <v-btn type="submit" :loading="formLogin.loading" block depressed color="primary" @click.prevent="signIn">Login</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'sign-in-page',
  data: function () {
    return {
      formLogin: {
        email: '',
        password: '',
        loading: false
      },
      rulesEmail: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      rulesPassword: [
        v => !!v || 'Password is required'
      ],
      valid: true
    }
  },
  mounted () {
    console.log()
  },
  methods: {
    signIn () {
      this.formLogin.loading = true
      if (this.$refs.formLogin.validate()) {
        const params = {
            email: this.formLogin.email,
            password: this.formLogin.password
          }
        this.$store.dispatch('auth/authLogin', params).then(result => {
          if (result.status === 200) {
            this.$store.dispatch('showSnackbar', {
              value: true,
              message: result.message,
              type: 'success'
            })
            setTimeout(() => this.$router.push({name: 'dashboard'}), 2000)
          } else {
            throw new Error(result.message)
          }
        }).catch(error => {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error,
            type: 'error'
          })
        }).finally(() => this.formLogin.loading = false)
      }
    }
  }
}
</script>

<style>

</style>
