<template>
  <v-row>
    <category-create :open="createCategory.open" @close="handleClose"></category-create>
    <category-edit :open="editCategory.open" :id="editCategory.id" @close="handleClose" />
    <v-dialog v-model="dialogDetailCategory" persistent max-width="500">
      <v-card>
        <template slot="progress">
          <v-progress-linear
            color="deep-purple"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <template v-if="category.data">
          <v-img
            :alt="`Picture of ${category.data.name}`"
            :src="category.data.file_path"
          ></v-img>
          <v-card-title>{{ category.data.name }}</v-card-title>
          <v-card-subtitle v-if="category.data.parent !== 'null'">
            <span>Parent</span>
            <span>{{ category.data.parent }}</span>
          </v-card-subtitle>
          <v-card-text>
            <v-chip v-if="category.data.is_navbar" color="info">Shown at Navbar</v-chip>
            <v-chip v-if="category.data.is_navbar" :color="category.data.is_published === 1 ? 'primary' : 'error'">{{ category.data.is_published === 1 ? 'Published': 'Not Published' }}</v-chip>
          </v-card-text>
          <v-card-text>
            <span>
              {{ category.data.description }}
            </span>
          </v-card-text>
        </template>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click="closeDetailCategory">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
    <v-col cols="12" sm="9">Category List</v-col>
    <v-col cols="12" sm="3">
      <v-btn @click="createCategory.open = true">Add Category</v-btn>
    </v-col>
    <v-col cols="12">
      <v-data-table
        :headers="headerCategories"
        :items="categories"
        :loading="loading"
        class="elevation-1"
        :items-per-page="10"
      >
        <template v-slot:item.is_published="{item}">
          <v-chip :color="item.is_published === 1 ? 'primary' : 'error'">{{ item.is_published === 1 ? 'Published' : 'Not Published' }}</v-chip>
        </template>
        <template v-slot:item.file_path="{item}">
          <v-img max-height="100" max-width="100" contain :src="item.file_path" :alt="`${item.name} thumbnail`"></v-img>
        </template>
        <template v-slot:item.updated_at="{item}">{{ new Date(item.updated_at).toLocaleDateString('id-ID') }}</template>
        <template v-slot:item.actions="{item}">
          <v-btn :loading="category.loading" icon>
            <v-icon color="primary" class="mr-3" @click="viewDetailCategory(item.id)">mdi-eye</v-icon>
          </v-btn>
          <v-icon color="warning" class="mr-3" @click="toggleEditDialog(item.id)">mdi-pencil</v-icon>
          <v-icon color="error" class="mr-3" @click="toggleDeleteDialog(item)">mdi-trash-can</v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import CategoryCreate from "./CategoryCreate";
import CategoryEdit from './CategoryEdit.vue';
export default {
  name: "CategoryList",
  components: {CategoryCreate, CategoryEdit},
  data: function () {
    return {
      categories: [],
      category: {
        data: null,
        loading: false
      },
      dialogDelete: false,
      dialogUpdateStatus: false,
      dialogDetailCategory: false,
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
      selectedCategory: null,
      createCategory: {
        open: false
      },
      editCategory: {
        open: false,
        id: ''
      },
      viewCategory: {
        open: false,
        id: ''
      }
    }
  },
  created () {
    this.fetchAdminCategories()
  },
  methods: {
    handleClose () {
      this.createCategory.open = false
      this.editCategory.open = false
      this.viewCategory.open = false
      this.fetchAdminCategories()
    },
    closeDetailCategory () {
      this.dialogDetailCategory = false
      this.category.data = null
    },
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
    toggleEditDialog (id) {
      if (this.editCategory.open) {
        this.editCategory.open = false
        this.editCategory.id = ''
        this.selectedCategory = null
      } else {
        this.selectedCategory = id
        this.editCategory.open = true
        this.editCategory.id = id
      }
    },
    viewDetailCategory (id) {
      this.category.loading = true
      this.$store.dispatch('category/adminFetchCategory', { category_id: id }).then(result => {
        if (result.status === 200) {
          this.category.data = result.data
          this.dialogDetailCategory = true
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          message: error.toString(),
          color: 'error'
        })
      }).finally(() => this.category.loading = false)
    }
  }
}
</script>

<style scoped>

</style>
