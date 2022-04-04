<template>
  <v-row>
    <v-dialog v-model="dialog" max-width="500">
        <add-payment-type v-if="dialogMode === 'create'" @cancel="handleCancel" @success="handleSuccess" />
        <edit-payment-type v-else-if="dialogMode === 'edit'" @cancel="handleCancel" @success="handleSuccess" :paymentType="selectedData" />
        <delete-payment-type v-else-if="dialogMode === 'delete'" @cancel="handleCancel" @success="handleSuccess" :paymentType="selectedData" />
    </v-dialog>
    <v-col cols="12" sm="9">
        <h2>Payment Type List</h2>
    </v-col>
    <v-col cols="12" sm="3">
        <v-btn @click="createItem" block>
            Add Payment Type
        </v-btn>
    </v-col>
    <v-col>
        <v-data-table
            :items="paymentTypes"
            :headers="headers"
            item-key="id"
            :loading="loading"
        >
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import AddPaymentType from "./AddPaymentType.vue"
import EditPaymentType from "./EditPaymentType.vue"
import DeletePaymentType from "./DeletePaymentType.vue"
export default {
    name: "PaymentTypes",
    components: {AddPaymentType, EditPaymentType, DeletePaymentType},
    data: function() {
        return {
            dialog: false,
            dialogMode: "create",
            selectedData: null,
            headers: [
                { text: "Name", value: "name" },
                { text: "Key", value: "key_name" },
                { text: "Actions", value: "actions", align: "right" },
            ],
        }
    },
    computed: {
        loading() {
            return this.$store.getters['paymentType/getPaymentTypeLoading']
        },
        paymentTypes() {
            return this.$store.getters['paymentType/getPaymentTypes']
        }
    },
    mounted() {
        this.fetchPaymentTypes();
    },
    methods: {
        createItem() {
            this.dialogMode = 'create'
            this.dialog = true
        },
        editItem(item) {
            this.selectedData = item
            this.dialogMode = "edit"
            this.dialog = true
        },
        deleteItem(item) {
            this.selectedData = item
            this.dialogMode = "delete"
            this.dialog = true
        },
        handleCancel() {
            this.dialog = false;
            this.dialogMode = "";
            this.selectedData = null
        },
        handleSuccess() {
            this.dialog = false;
            this.dialogMode = "";
            this.selectedData = null;
            this.fetchPaymentTypes()
        },
        fetchPaymentTypes() {
            this.$store.dispatch('paymentType/fetchPaymentTypes')
        }
    }
}
</script>

<style>

</style>