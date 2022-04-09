<template>
  <v-card>
    <v-card-title><h2>Delete Payment Type</h2></v-card-title>
    <v-card-text>
        Are you sure to delete {{ paymentType.name }}?
    </v-card-text>
    <v-card-actions>
        <v-btn :disabled="isSubmitting" @click="cancel" text>Cancel</v-btn>
        <v-btn :disabled="!valid" :loading="isSubmitting" @click="submit">Submit</v-btn>
    </v-card-actions>
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
        }
    },
    computed: {
        isSubmitting() {
            return this.$store.getters['paymentType/getPaymentTypeIsSubmitting']
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel');
        },
        submit() {
            this.$store.dispatch("paymentType/deletePaymentType", this.paymentType.id)
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