<template>
  <v-col cols="12" v-if="address">
    <delete-address
        v-if="deleteDialog"
        :open="deleteDialog"
        :address="selectedAddress"
        @update-success="handleUpdateSuccess"
        @close="closeDialog"
    />
    <edit-address
        v-if="editDialog"
        :open="editDialog"
        :address="selectedAddress"
        @update-success="handleUpdateSuccess"
        @close="closeDialog"
    />
    <v-row>
      <v-col cols="12" sm="9">
        <h6 class="font-weight-bold mb-3">{{address.name}} <v-icon v-if="address.is_default > 0" small left color="warning">mdi-check</v-icon></h6>
        <p class="mb-1">{{address.phone}}</p>
        <p>{{address.address}}</p>
      </v-col>
      <v-col cols="12" sm="3" class="d-flex flex-column">
        <v-btn color="black" small depressed class="mb-2 white--text" :disabled="address.is_default > 0" :loading="isSubmitting" @click="setAsDefault()">Set As Default</v-btn>
        <v-btn color="black" small outlined class="mb-2" @click="openEditDialog">Edit</v-btn>
        <v-btn color="black" small outlined class="mb-2" @click="openDeleteDialog">Delete</v-btn>
      </v-col>
    </v-row>
  </v-col>
</template>

<script>
import DeleteAddress from './DeleteAddress.vue'
import EditAddress from './EditAddress.vue'
export default {
  components: { EditAddress, DeleteAddress },
  name: 'Address',
  props: ['address'],
  data: function () {
    return {
      deleteDialog: false,
      editDialog: false,
      isSubmitting: false,
      selectedAddress: null
    }
  },
  methods: {
    openDeleteDialog () {
      this.selectedAddress = JSON.parse(JSON.stringify(this.address))
      this.deleteDialog = true
    },
    openEditDialog () {
      this.selectedAddress = JSON.parse(JSON.stringify(this.address))
      this.editDialog = true
    },
    closeDialog () {
      this.editDialog = false
      this.deleteDialog = false
      this.selectedAddress = null
    },
    setAsDefault () {
      let self = this
      this.isSubmitting = true
      this.$store.dispatch('customerAddress/changeActiveAddress', { address_id: this.address.id, customer_id: this.address.customer_id }).then(result => {
        self.$emit('update-success')
      }).catch(error => {
        self.$emit('update-failed')
        console.log('setAsDefault() error:', error)
      }).finally(() => {
        self.isSubmitting = false
      })
    },
    handleUpdateSuccess () {
      this.editDialog = false
      this.selectedAddress = null
      this.$emit('update-success')
    }
  }
}
</script>

<style>

</style>