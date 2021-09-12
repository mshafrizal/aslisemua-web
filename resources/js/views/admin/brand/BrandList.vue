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
    <v-col class="flex-grow-1">
      <h2>Brands</h2>
    </v-col>
    <v-col class="flex-grow-0">
      <v-btn @click="toAddBrand" block>Add Brand</v-btn>
    </v-col>
    <v-col cols="12">
      <v-skeleton-loader v-if="loading" type="table" />
      <v-simple-table v-else>
        <template v-slot:default>
          <thead>
            <tr>
              <th>Name</th>
              <th>Associated Product</th>
              <th>Updated At</th>
              <th>Updated By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="brand in brands">
              <tr :key="brand.id">
                <td>{{ brand.name }}</td>
                <td>{{ brand.associated_product }}</td>
                <td>{{ new Date(brand.updated_at).toLocaleDateString('id') }}</td>
                <td>{{ brand.updated_by }}</td>
                <td>
                  <div class="d-flex">
                    <v-btn color="primary" @click="toViewBrand(brand.id)" icon><v-icon>mdi-eye</v-icon></v-btn>
                    <v-btn color="warning" @click="toEditBrand(brand.id)" icon><v-icon>mdi-pencil</v-icon></v-btn>
                    <v-btn color="error" @click="toggleDeleteDialog(brand)" icon><v-icon>mdi-trash-can</v-icon></v-btn>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
      <v-col v-if="links">
        <div class="mx-auto d-flex justify-between" style="max-width: 300px">
          <template v-for="link in links">
            <v-btn :disabled="!link.url" :color="link.active ? 'primary': ''" small depressed @click="fetchBrands(link.url)" v-html="link.label" :key="link.label"></v-btn>
          </template>
        </div>
      </v-col>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'
import BrandCreate from "./BrandCreate";
import BrandEdit from "./BrandEdit";
export default {
  name: "BrandList",
  components: {BrandEdit, BrandCreate},
  data: function () {
    return {
      loading: true,
      dialogDelete: false,
      options: {},
      brands: [],
      page: 1,
      numOfPages: 0,
      total: 0,
      nextUrl: null,
      prevUrl: null,
      links: null,
      headerBrands: [
        { text: 'Name', align: 'start', sortable: false, value: 'name' },
        { text: 'Associated Product', align: 'end', sortable: false, value: 'associated_product' },
        { text: 'Updated At', align: 'start', sortable: false, value: 'updated_at' },
        { text: 'Updated By', align: 'start', sortable: false, value: 'updated_by' },
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
  created () {
    this.fetchBrands(process.env.MIX_APP_URL + `/api/v1/brands/`)
  },
  methods: {
    handleClose (reload) {
      this.createBrand.open = false
      this.editBrand.open = false
      this.editBrand.id = ''
      if (reload.value) this.fetchBrands(process.env.MIX_APP_URL + `/api/v1/brands/`)
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
          this.toggleDeleteDialog(process.env.MIX_APP_URL + `/api/v1/brands/`)
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.fetchBrands(process.env.MIX_APP_URL + `/api/v1/brands/`))
    },
    async fetchBrands (url) {
      this.loading = true
      axios({
        url: url.toString(),
        baseURL: '',
        method: 'get'
      }).then(response => {
        console.log('asxios', response)
        if (response.status === 200) {
          this.brands = response.data.results.data
          this.page = response.data.results.current_page
          this.total = response.data.results.total
          this.prevUrl = response.data.results.prev_page_url
          this.nextUrl = response.data.results.next_page_url
          this.links = response.data.results.links
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: 'Failed to fetch brands',
          color: 'error'
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
