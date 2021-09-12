<template>
  <v-container fill-height>
    <transition name="fade" mode="out-in">
      <v-card class="mx-auto" max-width="400" outlined v-if="!registerSuccess">
        <v-card-title class="text-center">
          <h1>SIGN UP TO ASLISEMUA</h1>
        </v-card-title>
        <v-form v-model="valid" ref="registerForm" lazy-validation @submit.prevent="register">
          <v-card-text>
            <span>Name</span>
            <v-text-field v-model="name" type="text" color="black" outlined single-line dense placeholder="Fullname" :rules="[requiredRules]"></v-text-field>

            <span>Phone Number</span>
            <v-text-field v-model="phone_number" type="text" color="black" outlined single-line dense placeholder="081209874567" :rules="[requiredRules, phoneRules]"></v-text-field>

            <span>Email</span>
            <v-text-field v-model="email" color="black" type="email" outlined single-line dense placeholder="your@email.com" :rules="[requiredRules, emailRules]" autocomplete="email"></v-text-field>

            <span>Password</span>
            <v-text-field
              v-model="password"
              color="black"
              :type="showPassword ? 'text' : 'password'"
              outlined
              single-line
              dense
              placeholder="********"
              :rules="[requiredRules]"
              @click:append="showPassword = !showPassword"
              autocomplete="new-password"
            />

            <span>Repeat Password</span>
            <v-text-field
              v-model="password_confirmation"
              color="black"
              :type="showPassword2 ? 'text' : 'password'"
              outlined
              single-line
              dense
              placeholder="********"
              :rules="[passwordConfirmationRules]"
              @click:append="showPassword2 = !showPassword2"
            />

            <span>City</span>
            <v-text-field v-model="city" color="black" type="text" outlined single-line dense :rules="[requiredRules]"/>

            <span>District</span>
            <v-text-field v-model="district" color="black" type="text" outlined single-line dense :rules="[requiredRules]"/>

            <span>Postal Code</span>
            <v-text-field v-model="postal_code" color="black" type="text" outlined single-line dense/>

            <span>Address</span>
            <v-textarea v-model="address" outlined :rules="[requiredRules]"></v-textarea>

            <v-radio-group v-model="gender" dense row color="black" hide-details>
              <v-radio label="Male" value="Male"></v-radio>
              <v-radio label="Female" value="Female"></v-radio>
            </v-radio-group>

            <v-checkbox v-model="agreement" dense label="I agree to Aslisemua’s Terms and Conditions & Privacy Policy" color="black" :rules="[requiredRules]"></v-checkbox>

            <v-btn type="submit" color="black" :loading="loading" :disabled="!valid" class="white--text" block>Sign Up</v-btn>
            <v-divider class="my-4"/>
            <v-btn link to="/login" color="black" :disabled="loading" block outlined>Sign In</v-btn>
          </v-card-text>
        </v-form>
      </v-card>
      <v-row v-else>
        <v-col>
          <h1 class="text-center text-3xl">Success!</h1>
          <p class="text-center">Verification link has been sent to your email.</p>
        </v-col>
      </v-row>
    </transition>
  </v-container>
</template>

<script>
export default {
  name: "Register",
  data: function () {
    return {
      agreement: false,
      email: '',
      name: '',
      gender: '',
      password: '',
      password_confirmation: '',
      phone_number: '',
      postal_code: '',
      city: '',
      district: '',
      address: '',
      valid: true,
      loading: false,
      registerSuccess: false,
      showPassword: false,
      showPassword2: false,
      requiredRules: v => !!v || 'This field is required',
      emailRules: v => /.+@.+\..+/.test(v) || 'E-mail invalid',
      phoneRules: v => /^08[0-9]{9,}$/.test(v) || 'Phone number invalid',
      passwordConfirmationRules: v => this.password === this.password_confirmation || 'Password does not match'
    }
  },
  methods: {
    register () {
      if (this.$refs.registerForm.validate()) {
        this.loading = true
        const params = {
          name: this.name,
          email: this.email,
          gender: this.gender,
          password: this.password,
          phone_number: this.phone_number,
          postal_code: this.postal_code,
          city: this.city,
          district: this.district,
          address: this.address
        }
        this.$axios.post(`/api/v1/customers/register`, params).then(response => {
          if (response.status === 200) {
            this.registerSuccess = true
            this.$store.dispatch('showSnackbar', {
              message: 'Register success! Please verify your email by clicking the link in your email',
              color: 'success'
            })
            this.$router.push('/')
          } else {
            this.$store.dispatch('showSnackbar', {
              value: true,
              message: response.data?.message,
              type: 'error'
            })
          }
        }).catch(error => {
          if (error.response) {
            Object.keys(error.response.data.error).forEach(key => {
              const attr = key
              error.response.data.error[key].forEach(text => {
                this.$store.dispatch('showSnackbar', {
                  value: true,
                  message: `Error: ${attr.toUpperCase()} - ${text}`,
                  type: 'error'
                })
              })
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
      } else {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: 'Please check your form again',
          type: 'warning'
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
