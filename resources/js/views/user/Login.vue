<template>
  <v-container
    fluid
    fill-height
    class="pa-0"
    style="align-items: stretch"
  >
    <v-row no-gutters>
      <v-col cols="12" md="6" class="d-flex justify-center align-center">
        <login-form />
      </v-col>
      <v-col cols="12" md="6" class="bg-signin d-flex justify-center items-stretch">
        <div class="d-flex justify-center items-stretch backdrop w-full">
          <div class="d-flex flex-column justify-center text-center pa-4" style="max-width: 400px">
            <h1 class="text-3xl mb-10 white--text">New User</h1>
            <p class="text-xl white--text">Create an account to start buying and selling your wardrobe</p>
            <p class="text-xl white--text">Set up your profile, manage your orders, build your wishlist and more.</p>
            <v-btn link to="/register" color="black" class="white--text mt-5">Sign Up</v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import LoginForm from "../../components/login/LoginForm";
export default {
  name: "LoginUser",
  components: {LoginForm}
}
</script>

<style scoped>
  .bg-signin {
    background: url('../../../images/bg-signin.png');
    background-repeat: no-repeat;
    background-size: cover;
  }
  .backdrop {
    backdrop-filter: blur(10px);
  }
</style>
