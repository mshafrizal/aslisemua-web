<template>
  <v-row>
    <brand-create :open="createBrand.open" @close="handleClose"></brand-create>
    <brand-edit :open="editBrand.open" :brand-id="editBrand.id" @close="handleClose"></brand-edit>
    <v-dialog
      :loading="viewBrand.loading"
      v-model="viewBrand.open"
      max-width="374"
    >
      <v-card>
        <template slot="progress">
          <v-progress-linear
            color="primary"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <template v-if="viewBrand.data">
          <v-img :src="viewBrand.data.file_path" >
            <template v-slot:placeholder>
              <v-row
                class="fill-height ma-0"
                align="center"
                justify="center"
              >
                <v-progress-circular
                  indeterminate
                  color="grey lighten-5"
                ></v-progress-circular>
              </v-row>
            </template>
          </v-img>
          <v-card-title>{{ viewBrand.data.name }}</v-card-title>
          <v-card-text>
            <p>
              {{ viewBrand.data.description }}
            </p>
            <p>
              {{ viewBrand.data.associated_product }}&nbsp;Products
            </p>
          </v-card-text>
        </template>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialogDelete"
      persistent
      max-width="400"
    >
      <v-card>
        <v-card-title class="headline">
          Delete Brand
        </v-card-title>
        <v-card-text>Are you sure to delete {{ selectedBrand ? selectedBrand.name : '' }}?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="grey darken-3"
            text
            @click="toggleDeleteDialog"
            :disabled="loading"
          >
            Cancel
          </v-btn>
          <v-btn
            color="primary"
            text
            @click="deleteBrand"
            :loading="loading"
          >
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-col cols="12" sm="10">
      <h3 class="text-h3 font-weight-bold">Brands</h3>
    </v-col>
    <v-col cols="12" sm="2">
      <v-btn @click="toAddBrand" block>Add Brand</v-btn>
    </v-col>
    <v-col cols="12">
      <v-data-table
        :headers="headerBrands"
        :items="dataBrands ? dataBrands.data : []"
        :loading="loading"
        class="elevation-1"
        :items-per-page="10"
      >
        <template v-slot:item.updated_at="{item}">{{ new Date(item.updated_at).toLocaleDateString('id-ID') }}</template>
        <template v-slot:item.actions="{item}">
          <v-icon color="primary" class="mr-3" @click="toViewBrand(item.id)">mdi-eye</v-icon>
          <v-icon color="warning" class="mr-3" @click="toEditBrand(item.id)">mdi-pencil</v-icon>
          <v-icon color="error" @click="toggleDeleteDialog(item)">mdi-delete-outline</v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import BrandCreate from "./BrandCreate";
import BrandEdit from "./BrandEdit";
export default {
  name: "BrandList",
  components: {BrandEdit, BrandCreate},
  data: function () {
    return {
      loading: true,
      dataBrands: null,
      dialogDelete: false,
      headerBrands: [
        { text: 'Name', align: 'start', sortable: true, value: 'name' },
        { text: 'Associated Product', align: 'end', sortable: true, value: 'associated_product' },
        { text: 'Updated At', align: 'start', sortable: true, value: 'updated_at' },
        { text: 'Updated By', align: 'start', sortable: true, value: 'updated_by' },
        { text: 'Actions', align: 'center', sortable: false, value: 'actions' },
      ],
      createBrand: {
        open: false
      },
      editBrand: {
        open: false,
        id: '',
      },
      selectedBrand: null,
      viewBrand: {
        data: null,
        loading: false,
        open: false
      }
    }
  },
  mounted () {
    this.fetchBrands()
  },
  methods: {
    handleClose () {
      this.createBrand.open = false
      this.editBrand.open = false
      this.editBrand.id = ''
      this.fetchBrands()
    },
    toggleDeleteDialog (item) {
      this.dialogDelete = !this.dialogDelete
      if (!this.selectedBrand) this.selectedBrand = item
      else this.selectedBrand = null
    },
    deleteBrand () {
      this.loading = true
      this.$store.dispatch('brand/deleteBrand', { brand_id: this.selectedBrand.id }).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            type: 'success',
            message: result.message
          })
          this.toggleDeleteDialog()
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.fetchBrands())
    },
    fetchBrands () {
      this.loading = true
      this.$store.dispatch('brand/fetchBrands').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else this.$set(this, 'dataBrands', result.results)
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    toAddBrand () {
      this.createBrand.open = true
    },
    toEditBrand (id) {
      this.editBrand.open = true
      this.editBrand.id = id
    },
    toViewBrand (id) {
      this.viewBrand.open = true
      this.viewBrand.loading = true
      this.viewBrand.data = null
      this.$store.dispatch('brand/fetchBrand', { brand_id: id }).then(result => {
        this.viewBrand.data = result.results
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.response ? error.response.message : error.message,
          color: 'error'
        })
        this.viewBrand.open = false
        this.viewBrand.data = null
      }).finally(() => {
        this.viewBrand.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
