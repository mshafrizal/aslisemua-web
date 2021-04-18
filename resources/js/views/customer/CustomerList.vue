<template>
  <v-row>
    <v-col cols="12"><h3>Customer List</h3></v-col>
    <v-col cols="12">
       <v-data-table
        class="elevation-1"
        :headers="headers"
        :items="customers"
        :loading="loading"
      >
         <template v-slot:item.is_active="{ item }">
           <v-chip :color="item.is_active ? 'success' : 'error'">
             {{ item.is_active ? 'Active' : 'Banned' }}
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
        { text: 'Phone', align: 'start', sortable: false, value: 'phone' },
        { text: 'Status', align: 'start', sortable: false, value: 'is_active' },
        { text: 'Actions', align: 'start', sortable: false, value: 'actions' },
      ],
      customers: [],
      loading: true,
    }
  },
  mounted () {
    this.fetchCustomerList()
  },
  methods: {
    fetchCustomerList () {
      for (let i = 0; i < 20; i++) {
        this.customers.push({
          id: i+1,
          name: 'Jonathan Morningstar',
          email: 'jonathan@gmail.com',
          phone: '08123881262',
          is_active: true
        })
      }
      this.loading = false
    },
    toCustomerDetail (customerId) {
      this.$router.push(`/admin/customer/${customerId}/detail`)
    }
  }
}
</script>

<style>

</style>
