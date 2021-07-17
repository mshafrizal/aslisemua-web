<template>
  <v-row>
    <v-col cols="12">Create Category</v-col>
    <v-col cols="12" sm="4">
      <v-card>
        <v-form ref="formEditCategory" v-model="valid">
          <v-card-title>Category Thumbnail</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-img v-if="fileUrl" :src="fileUrl" contain></v-img>
            <v-img v-else :src="thumbnail" contain></v-img>
            <v-file-input
              v-model="formEditCategory.file"
              :rules="fileRules"
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Pick a thumbnail"
              prepend-icon="mdi-camera"
              clearable
              required
              show-size
              label="Thumbnail"
            ></v-file-input>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-title>Category Information</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-text-field
              v-model.trim="formEditCategory.name"
              :rules="nameRules"
              label="Name"
              name="name"
              required
            ></v-text-field>
            <v-textarea
              name="description"
              label="Description"
              v-model.trim="formEditCategory.description"
              :rules="[v => !!v || 'Please provide meaningful description']"
              required
            ></v-textarea>
            <v-select
              :items="parentCategory"
              label="Parent Category"
              item-text="name"
              item-value="id"
              v-model="formEditCategory.parent"
              hint="Select parent category if you wish this category to be sub category"
              clearable
            ></v-select>
            <v-text-field v-model="formEditCategory.updated_at" label="Last Updated at" prepend-icon="mdi-calendar" readonly></v-text-field>
            <v-text-field v-model="formEditCategory.updated_by" label="Last Updated by" prepend-icon="mdi-account" readonly></v-text-field>
            <v-checkbox v-model="formEditCategory.is_publish" label="Publish" color="primary"></v-checkbox>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn color="error" href="/admin/category/list" text :disabled="loading">Cancel</v-btn>
            <v-btn color="primary" depressed :disabled="!valid" :loading="loading" @click="handleSubmit">Submit</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "CategoryEdit",
  data: function () {
    return {
      valid: true,
      formEditCategory: {
        name: '',
        file: null,
        description: '',
        parent: null,
        updated_at: '',
        updated_by: '',
        is_publish: false,
      },
      thumbnail: '',
      loading: false,
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length > 3) || 'Name must be more than 3 characters',
      ],
      fileRules: [
        value => !value || value.size < 2000000 || 'Thumbnail size should be less than 2 MB!'
      ],
      parentCategory: []
    }
  },
  computed: {
    fileUrl () {
      if (!this.formEditCategory.file) return
      return URL.createObjectURL(this.formEditCategory.file)
    }
  },
  created () {
    const result = this.fetchParentCategories()
    if (result) this.fetchCategoryDetail()
  },
  methods: {
    async fetchCategoryDetail () {
      this.loading = true
      this.$store.dispatch('category/adminFetchCategory', { category_id: this.$route.params.id }).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          console.log(result.data)
          this.formEditCategory.name = result.data.name
          this.formEditCategory.description = result.data.description
          this.formEditCategory.parent = result.data.parent
          this.formEditCategory.updated_at = new Date(result.data.updated_at).toLocaleDateString('id-ID')
          this.formEditCategory.updated_by = result.data.updated_by
          this.formEditCategory.is_publish = result.data.is_publish
          this.thumbnail = '/storage/' + result.data.file_path
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => this.loading = false)
    },
    async fetchParentCategories () {
      this.loading = true
      this.$store.dispatch('category/adminFetchCategories').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.parentCategory = result.data
          return true
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
        return false
      }).finally(() => {
        this.loading = false
      })
    },
    handleSubmit () {
      this.loading = true
      let formData = new FormData()
      if (this.formEditCategory.file) {
        formData.append('file', this.formEditCategory.file, this.formEditCategory.file.name)
      }
      formData.append('name', this.formEditCategory.name)
      formData.append('description', this.formEditCategory.description)
      formData.append('parent', this.formEditCategory.parent)
      formData.append('is_publish', this.formEditCategory.is_publish)
      this.$store.dispatch('category/adminUpdateCategory', {
        category_id: this.$route.params.id,
        data: formData
      }).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            value: true,
            type: 'success',
            message: result.message
          })
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          type: 'error',
          message: error
        })
      }).finally(() => {
        this.loading = false
        this.formEditCategory = {
          name: '',
          file: null,
          description: '',
          parent: null,
          updated_at: '',
          updated_by: ''
        }
        this.thumbnail = ''
        this.$router.push('/admin/category/list')
      })
    }
  }
}
</script>

<style scoped>

</style>
