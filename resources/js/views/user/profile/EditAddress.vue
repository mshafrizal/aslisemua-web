<template>
  <v-dialog
      v-model="open"
      persistent
      max-width="600"
  >
    <v-card>
      <v-card-title>Edit Address</v-card-title>
      <v-divider></v-divider>
      <v-form>
        <v-card-text v-if="formEditAddress">
          <v-text-field
            v-model="formEditAddress.name"
            outlined
            dense
            name="name"
            label="Receiver's Name"
            id="name"
            :rules="[requiredRules]"
            color="black"
          ></v-text-field>
          <v-text-field
            v-model="formEditAddress.phone"
            outlined
            dense
            name="phone"
            label="Phone"
            id="phone"
            :rules="[requiredRules]"
            color="black"
          ></v-text-field>
          <v-text-field
            v-model="formEditAddress.city"
            outlined
            dense
            label="City"
            :rules="[requiredRules]"
            color="black"
          />
          <v-text-field
            v-model="formEditAddress.district"
            outlined
            dense
            label="District"
            :rules="[requiredRules]"
            color="black"
          />
          <v-text-field
            v-model="formEditAddress.zip_code"
            outlined
            dense
            label="Zip Code"
            :rules="[requiredRules]"
            color="black"
          />
          <v-textarea
            v-model="formEditAddress.address"
            outlined
            label="Address"
            :rules="[requiredRules]"
            color="black"
          />
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" outlined :disabled="isSubmitting" @click="cancel">Cancel</v-btn>
          <v-btn color="black" class="white--text" depressed :loading="isSubmitting" @click="updateAddress">Update</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'EditAddress',
  props: ['address', 'open'],
  data: function () {
    return {
      formEditAddress: null,
      editAddress: null,
      isSubmitting: false,
      requiredRules: v => !!v || 'This field is required'
    }
  },
  mounted () {
    this.formEditAddress = null
    this.formEditAddress = {
      name: this.address.name,
      phone: this.address.phone,
      address: this.address.address,
      city: this.address.city,
      district: this.address.district,
      zip_code: this.address.zip_code,
    }
  },
  methods: {
    updateAddress () {
      this.isSubmitting = true
      this.$store.dispatch('customerAddress/updateAddress', { customer_id: this.address.customer_id, address_id: this.address.id, body: this.formEditAddress}).then(result => {
        this.$emit('update-success')
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: 'Failed. Please try again.',
          type: 'error'
        })
        console.log('updateAddress() error:', error)
        this.$emit('update-failed')
      }).finally(() => {
        this.isSubmitting = false
      })
    },
    cancel () {
      this.$emit('close')
    }
  },
  beforeDestroy () {
    this.formEditAddress = null
  }
}
</script>

<style>

</style>