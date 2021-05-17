<template>
  <v-row>
    <v-dialog v-model="dialogUpdateStatus" v-if="dialogUpdateStatus" persistent max-width="500">
      <v-card>
        <v-card-title>Change Category Status</v-card-title>
        <v-card-text>Are you sure to change {{ selectedCategory.name }} category status?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" :disabled="loading" text @click="toggleDialogStatus">Cancel</v-btn>
          <v-btn color="primary" :loading="loading" text>Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogDelete" v-if="dialogDelete" persistent max-width="500">
      <v-card>
        <v-card-title>Delete Category</v-card-title>
        <v-card-text>Are you sure to delete {{selectedCategory.name}} category?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" :disabled="isSubmitting" text @click="toggleDeleteDialog">Cancel</v-btn>
          <v-btn color="primary" :loading="isSubmitting" text @click="deleteCategory">Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-col cols="12" sm="10">Category List</v-col>
    <v-col cols="12" sm="2">
      <v-btn href="/admin/category/create" block>Add Category</v-btn>
    </v-col>
    <v-col cols="12">
      <v-data-table
        :headers="headerCategories"
        :items="categories"
        :loading="loading"
        class="elevation-1"
        :items-per-page="10"
      >
        <template v-slot:item.file_path="{item}">
          <v-img max-height="100" max-width="100" contain :src="resolveImagePath(item.file_path)" :alt="`${item.name} thumbnail`"></v-img>
        </template>
        <template v-slot:item.updated_at="{item}">{{ new Date(item.updated_at).toLocaleDateString('id-ID') }}</template>
        <template v-slot:item.actions="{item}">
          <v-icon color="warning" class="mr-3" @click="toEditCategory(item.id)">mdi-pencil</v-icon>
          <v-icon color="error" class="mr-3" @click="toggleDeleteDialog(item)">mdi-trash-can</v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "CategoryList",
  data: function () {
    return {
      categories: [],
      dialogDelete: false,
      dialogUpdateStatus: false,
      headerCategories: [
        { text: 'Thumbnail', align: 'start', sortable: false, value: 'file_path' },
        { text: 'Name', align: 'start', sortable: true, value: 'name' },
        { text: 'Status', align: 'start', sortable: true, value: 'is_published' },
        { text: 'Updated At', align: 'start', sortable: true, value: 'updated_at' },
        { text: 'Updated By', align: 'start', sortable: true, value: 'updated_by' },
        { text: 'Actions', align: 'center', sortable: false, value: 'actions' },
      ],
      isSubmitting: false,
      loading: true,
      selectedCategory: null
    }
  },
  created () {
    this.fetchAdminCategories()
  },
  methods: {
    deleteCategory () {
      this.isSubmitting = true
      const params = {
        category_id: this.selectedCategory.id
      }
      this.$store.dispatch('category/adminDeleteCategory', params).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            type: 'success',
            message: result.message
          })
          this.toggleDeleteDialog()
          this.fetchAdminCategories()
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.isSubmitting = false)
    },
    fetchAdminCategories () {
      this.loading = true
      this.$store.dispatch("category/adminFetchCategories").then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.categories = result.data
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    resolveImagePath (path) {
      return '/storage/' + path
    },
    toggleDialogStatus (category) {
      if (this.dialogUpdateStatus) this.selectedCategory = null
      else this.selectedCategory = category
      this.dialogUpdateStatus = !this.dialogUpdateStatus
    },
    toggleDeleteDialog (category) {
      if (this.dialogDelete) this.selectedCategory = null
      else this.selectedCategory = category
      this.dialogDelete = !this.dialogDelete
    },
    toEditCategory (id) {
      this.$router.push(`/admin/category/${id}/edit`)
    }
  }
}
</script>

<style scoped>

</style>
