<template>
  <v-card>
      <v-card-title><h2>Edit Payment Type</h2></v-card-title>
      <v-form v-if="paymentType" ref="editPaymentTypeRef" v-model="valid" @submit.prevent="submit">
          <v-card-text>
              <v-text-field v-model="formModel.name" label="Name" placeholder="Credit"></v-text-field>
              <v-text-field v-model="formModel.key_name" label="Key Name" placeholder="credit"></v-text-field>
          </v-card-text>
          <v-card-actions>
              <v-btn :disabled="isSubmitting" @click="cancel" text>Cancel</v-btn>
              <v-btn :disabled="!valid" type="submit">Submit</v-btn>
          </v-card-actions>
      </v-form>
  </v-card>
</template>

<script>
export default {
    name: "EditPaymentType",
    props: {
        paymentType: { type: Object, default: null }
    },
    data: function () {
        return {
            valid: true,
            formModel: {
                id: "",
                name: "",
                key_name: "",
            },
        }
    },
    computed: {
        isSubmitting() {
            return this.$store.getters['paymentType/getPaymentTypeIsSubmitting']
        }
    },
    mounted() {
        this.formModel.id = this.paymentType.id
        this.formModel.name = this.paymentType.name
        this.formModel.key_name = this.paymentType.key_name
    },
    methods: {
        cancel() {
            this.$emit('cancel');
            this.$refs.editPaymentTypeRef.reset();
            this.$refs.editPaymentTypeRef.resetValidation();
        },
        submit() {
            this.$store.dispatch("paymentType/updatePaymentType", this.formModel)
            .then(() => {
                this.$emit("success")
            })
            .catch(error => {
                this.$store.dispatch('showSnackbar', {
                    message: error,
                    type: 'error'
                })
            })
        }
    }
}
</script>

<style>

</style>