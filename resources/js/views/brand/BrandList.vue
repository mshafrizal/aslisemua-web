<template>
  <v-row>
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
            color="error"
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
    <v-col cols="12" sm="10">Brand List</v-col>
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
        <template v-slot:item.file_path="{item}">
          <v-img max-height="100" max-width="100" contain :src="resolveImagePath(item.file_path)" :alt="`${item.name} logo`"></v-img>
        </template>
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
export default {
  name: "BrandList",
  data: function () {
    return {
      loading: true,
      dataBrands: null,
      dialogDelete: false,
      headerBrands: [
        { text: 'Logo', align: 'start', sortable: false, value: 'file_path' },
        { text: 'Name', align: 'start', sortable: true, value: 'name' },
        { text: 'Associated Product', align: 'end', sortable: true, value: 'associated_product' },
        { text: 'Updated At', align: 'start', sortable: true, value: 'updated_at' },
        { text: 'Updated By', align: 'start', sortable: true, value: 'updated_by' },
        { text: 'Actions', align: 'center', sortable: false, value: 'actions' },
      ],
      selectedBrand: null
    }
  },
  mounted () {
    this.fetchBrands()
  },
  methods: {
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
    resolveImagePath (path) {
      return '../storage/' + path
    },
    toAddBrand () {
      this.$router.push('/admin/brand/create')
    },
    toEditBrand (id) {
      this.$router.push(`/admin/brand/${id}/edit`)
    },
    toViewBrand (id) {
      this.$router.push(`/admin/brand/${id}/detail`)
    }
  }
}
</script>

<style scoped>

</style>
