<template>
  <v-dialog
      v-model="open"
      persistent
      max-width="600"
  >
    <v-card>
      <v-card-title>Delete Address</v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <p class="mt-3 mb-0">Are you sure to delete address?</p>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
          <v-btn color="black" outlined :disabled="isSubmitting" @click="cancel">Cancel</v-btn>
          <v-btn color="error" class="white--text" depressed :loading="isSubmitting" @click="deleteAddress">Delete</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'DeleteAddress',
  props: ['address', 'open'],
  data: function () {
    return {
      isSubmitting: false,
    }
  },
  methods: {
    cancel () {
      this.$emit('close')
    },
    deleteAddress () {
      this.isSubmitting = true
      this.$store.dispatch('customerAddress/deleteAddress', { customer_id: this.address.customer_id, address_id: this.address.id }).then(result => {
        this.$emit('update-success')
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          type: 'error',
          message: 'Failed. Please try again.',
          value: true
        })
        console.log('deleteAddress() error:', error)
      }).finally(() => this.isSubmitting = false)
    }
  }
}
</script>

<style>

</style>