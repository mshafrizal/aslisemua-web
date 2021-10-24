<template>
  <v-row>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="400"
    >
      <v-card>
        <v-form v-model="addAddressValid" @submit.prevent="submitNewAddress" ref="addAddressForm">
          <v-card-title>Add New Address</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-text-field
              v-model="formNewAddress.name"
              label="Receiver Name"
              outlined
              dense
              :rules="[requiredRules]"
              color="black"
            />
            <v-text-field
              v-model="formNewAddress.phone"
              label="Phone"
              dense
              outlined
              :rules="[requiredRules]"
              color="black"
            />
            <v-textarea
              v-model="formNewAddress.address"
              outlined
              label="Address"
              :rules="[requiredRules]"
              color="black"
            />
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="closeDialog" :disabled="isSubmitting" outlined>Back</v-btn>
            <v-btn type="submit" :loading="isSubmitting" color="black" class="white--text">Save</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <v-col cols="12">
      <v-btn @click="openDialog" :disabled="isSubmitting" color="black" class="white--text" depressed>Add Address</v-btn>
    </v-col>
    <v-col cols="12" md="8">
      <v-card flat :loading="loading || isSubmitting">
        <template slot="progress">
          <v-progress-linear
            color="black"
            height="5"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-skeleton-loader
          type="article, actions"
          v-if="loading"
        ></v-skeleton-loader>
        <v-card-text>
          <v-row>
            <template v-for="address in addresses">
              <Address 
                  :address="address" 
                  :key="address.id" 
                  @update-success="handleUpdateSuccess"
                  @update-failed="handleUpdateFailed"    
              />
            </template>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Address from './Address.vue'
export default {
  name: "MyAddresses",
  components: {Address},
  data: function () {
    return {
      addAddressValid: true,
      addresses: [],
      formNewAddress: {
        name: '',
        phone: '',
        address: ''
      },
      dialog: false,
      loading: false,
      isSubmitting: false,
      requiredRules: v => !!v || 'This field is required'
    }
  },
  mounted () {
    this.getAddresses()
  },
  methods: {
    handleUpdateSuccess () {
      console.log('handleUpdateSuccess() called')
      this.$store.dispatch('showSnackbar', {
        value: true,
        message: 'Success',
        type: 'success'
      })
      this.getAddresses()
    },
    handleUpdateFailed () {
      this.$store.dispatch('showSnackbar', {
        value: true,
        message: 'Failed. Please try again.',
        type: 'error'
      })
      this.getAddresses()
    },
    closeDialog () {
      this.dialog = false
      this.formNewAddress = {
        name: '',
        phone: '',
        address: ''
      }
    },
    openDialog () {
      this.dialog = true
    },
    submitNewAddress () {
      this.isSubmitting = false
      this.$store.dispatch('customer/AddAddress', this.formNewAddress).then(result => {
        if (result.status === 201) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: 'New address saved',
            type: 'success'
          })
          this.closeDialog()
          this.getAddresses()
        }
      }).catch(error => {
        console.log(error)
        if (error.response) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.response?.data?.message,
            type: 'error`'
          })
        } else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.message.toString(),
            type: 'error`'
          })
        }
      }).finally(() => {
        this.isSubmitting = false
        this.getAddresses()
      })
    },
    getAddresses () {
      // call api
      this.loading = true
      this.addresses = []
      this.$store.dispatch('customer/fetchAddresses').then(result => {
        console.log('getAddresses', result)
        if (result.status === 200) {
          this.addresses = result.results
        }
      }).catch(error => {
        if (error.response) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.response.data.message,
            type: 'error`'
          })
        } else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: error.message.toString(),
            type: 'error`'
          })
        }
      }).finally(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
