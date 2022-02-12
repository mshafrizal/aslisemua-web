<template>
  <v-row>
    <v-col cols="12"><h2>Payment Type List</h2></v-col>
    <v-col>
        <v-data-table
            :data="[]"
            :headers="headers"
        >
        </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
    name: "PaymentTypes",
    data: function() {
        return {
            headers: [
                { text: "Name", value: "name" },
                { text: "Key", value: "key_name" },
                { text: "Actions", value: "" },
            ]
        }
    }
}
</script>

<style>

</style>