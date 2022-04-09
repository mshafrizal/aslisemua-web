<template>
  <v-container class="mb-32 mt-10">
    <v-row>
      <v-col cols="12" class="text-center">
          <v-row>
              <v-col cols="12">
                <h1 class="text-3xl mx-auto">CONSIGN WITH US</h1>
              </v-col>
              <v-col cols="12">
                <p>Please fill this form before consigning. Our team will contact you soon.</p>
              </v-col>
          </v-row>
      </v-col>
      <v-col cols="12">
          <v-row justify="center">
              <v-col cols="12" sm="4">
                <consignment-form @success="handleSuccess" />
              </v-col>
          </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ConsignmentForm from "./ConsignmentForm.vue"
export default {
    name: "Consignment",
    components: {ConsignmentForm},
    methods: {
        handleSuccess() {
            setTimeout(() => {
                this.$router.push("/")
            }, 1000);
        }
    }
}
</script>

<style>

</style>