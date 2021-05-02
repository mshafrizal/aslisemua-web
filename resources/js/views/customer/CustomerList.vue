<template>
  <v-row>
    <v-col cols="12"><h3>Customer List</h3></v-col>
    <v-col cols="12">
       <v-data-table
        class="elevation-1"
        :headers="headers"
        :items="customers ? customers : []"
        :loading="loading"
      >
         <template v-slot:item.status="{ item }">
           <v-chip :color="item.status === 'active' ? 'success' : 'error'">
             {{ item.status.toUpperCase() }}
           </v-chip>
         </template>
         <template v-slot:item.actions="{ item }">
           <v-btn depressed color="primary" icon @click="toCustomerDetail(item.id)"><v-icon>mdi-eye</v-icon></v-btn>
         </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'customer-list-view',
  data: function () {
    return {
      headers: [
        { text: 'Customer Name', align: 'start', sortable: false, value: 'name' },
        { text: 'Email', align: 'start', sortable: false, value: 'email' },
        { text: 'Phone', align: 'start', sortable: false, value: 'phone_number' },
        { text: 'Status', align: 'start', sortable: false, value: 'status' },
        { text: 'Actions', align: 'start', sortable: false, value: 'actions' }
      ],
      customers: null,
      loading: true,
    }
  },
  mounted () {
    this.fetchCustomerList()
  },
  methods: {
    fetchCustomerList () {
      this.loading = true
      this.$store.dispatch('customer/fetchCustomers').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.customers = result.data
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    toCustomerDetail (customerId) {
      this.$router.push(`/admin/customer/${customerId}/detail`)
    },
    toEditCustomer (customerId) {
      this.$router.push(`/admin/customer/${customerId}/edit`)
    }
  }
}
</script>

<style>

</style>
