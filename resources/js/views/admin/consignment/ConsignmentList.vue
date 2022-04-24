<template>
  <v-row>
    <v-col cols="12">
        <h2>Consignment Request List</h2>
    </v-col>
    <v-col>
        <v-data-table
            :items="consignment.data.data"
            :headers="headers"
            item-key="id"
            :loading="loading"
            :server-items-length="consignment.data.total"
            :items-per-page="consignment.data.per_page"
            :page="consignment.data.page"
            @update:page="handlePageChange"
        >
        </v-data-table>
    </v-col>
  </v-row>
</template>
<script>

// created_at: "2022-04-05T17:37:27.000000Z"
// customer_id: "d3c121d0-422c-4509-8613-ffccc71a7c55"
// email: "mshafrizal@gmail.com"
// file_id: "624c7e58af2277ccc855f97e"
// filename: "CONSIGNMENT1649180247elevation sample.png"
// goods_type: "YSQL Bag"
// id: "9edf212a-f16d-4459-8248-8cdafbb780f5"
// image_name: "CONSIGNMENT1649180247elevation sample.png"
// image_path: "https://ik.imagekit.io/vin64b9qvp9/Consignments/CONSIGNMENT1649180247elevation_sample_cRyild92d.png"
// kondisi: "Pristine"
// name: "Muhammad Shafrizal"
// phone: "082298676740"
// updated_at: "2022-04-05T17:37:27.000000Z"
export default {
    name: "ConsigmentList",
    data: function () {
        return {
            consignment: {
                data: {
                    current_page: 1,
                    data: [],
                    first_page_url: "",
                    from: 1,
                    last_page: 1,
                    last_page_url: "",
                    links: [],
                    next_page_url: null,
                    path: "",
                    per_page: 10,
                    prev_page_url: null,
                    to: 1,
                    total: 1,
                },
                loading: true
            },
            headers: [
                { text: "Customer Name", value: "name" },
                { text: "Phone", value: "phone" },
                { text: "Email", value: "email" },
                { text: "Goods Type", value: "goods_type" },
                { text: "Condition", value: "kondisi" },
                { text: "Submitted At", value: "created_at" },
            ],
        }
    },
    computed: {
        loading() {
            return this.$store.getters['consignments/isConsignmentLoading']
        }
    },
    mounted() {
      this.fetchConsignments(process.env.MIX_APP_URL + `/api/v1/consignments/private/ `)  
    },
    methods: {
        handlePageChange(page) {

        },
        deleteItem(item) {
            this.selectedData = item
            this.dialogMode = "delete"
            this.dialog = true
        },
        fetchConsignments(url) {
            this.$store.dispatch('consignments/updateConsignmentLoading', true)
            this.$axios({
                url: url,
            })
            .then((response) => {
                if (response.status === 200) {
                    this.consignment.data = response.data.data
                }
            }).catch(error => {
                this.$store.dispatch('showSnackbar', {
                    type: 'error',
                    message: error
                })
            })
            .finally(() => {
                this.$store.dispatch('consignments/updateConsignmentLoading', false)
            })
        },
    }
}
</script>

<style>

</style>