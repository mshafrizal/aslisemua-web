<template>
  <v-row>
    <v-dialog v-model="dialog" max-width="500">
        <add-payment-type v-if="dialogMode === 'create'" @cancel="handleCancel" @success="handleSuccess" />
        <edit-payment-type v-else-if="dialogMode === 'edit'" @cancel="handleCancel" @success="handleSuccess" :paymentType="selectedData" />
        <delete-payment-type v-else-if="dialogMode === 'delete'" @cancel="handleCancel" @success="handleSuccess" :paymentType="selectedData" />
        <add-bank v-else-if="dialogMode === 'addbank'" @cancel="handleCancel" @success="handleSuccess" :paymentType="selectedData" />
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
            :single-expand="false"
            :expanded.sync="expanded"
            show-expand
            @item-expanded="handleItemExpanded"
        >
            <template v-slot:item.actions="{ item }">
                <v-btn @click="addBank(item)" text>Add Bank</v-btn>
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

            <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length">
                    <template v-if="item.withBank">
                        <div class="d-flex">
                            <template v-for="(payType, i) in item.withBank">
                                <div class="d-flex flex-column" :key="i">
                                    <p class="mt-2"><strong>{{ payType.name }}</strong></p>
                                    <div class="d-flex">
                                        <template v-for="(bank, j) in payType.bank">
                                            <div class="d-flex flex-column mr-2 p-2 bank-item" :key="j">
                                                <img class="mb-1" style="max-width: 150px; height: auto" :src="bank.image_path" :alt="bank.alt_image" />
                                                <div class="d-flex">
                                                    <p class="mb-0 flex">{{ bank.name }}</p>
                                                    <v-btn icon x-small><v-icon>mdi-pencil</v-icon></v-btn>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </template>
                        </div>
                    </template>
                </td>
            </template>
        </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import AddPaymentType from "./AddPaymentType.vue"
import EditPaymentType from "./EditPaymentType.vue"
import DeletePaymentType from "./DeletePaymentType.vue"
import AddBank from "./AddBank.vue"
export default {
    name: "PaymentTypes",
    components: {AddPaymentType, EditPaymentType, DeletePaymentType, AddBank},
    data: function() {
        return {
            expanded: [],
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
        handleItemExpanded (payload) {
            console.log("this.handleItemExpanded", payload)
            this.$store.dispatch('paymentType/fetchBankByPaymentType', payload.item.id)
            .then(result => {
                payload.item.withBank = result.data.results
            })
        },
        createItem() {
            this.dialogMode = 'create'
            this.dialog = true
        },
        addBank(item) {
            this.selectedData = item
            this.dialogMode = "addbank"
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
        },
    }
}
</script>

<style scoped>
    .bank-item {
        border: 1px solid #d3d3d3;
        padding: 8px;
        margin-bottom: 8px;
    }
</style>>

</style>