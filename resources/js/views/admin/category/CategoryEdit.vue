<template>
  <v-dialog v-model="open" max-width="400" persistent>
    <v-card v-if="loading">
      <v-skeleton-loader
        class="mx-auto"
        max-width="400"
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-card v-else>
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
          <v-checkbox v-model="formEditCategory.is_published" label="Publish" color="primary"></v-checkbox>
          <v-checkbox v-model="formEditCategory.is_navbar" label="Shown at Navbar" color="primary"></v-checkbox>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="error" @click="handleClose" text :disabled="loading">Cancel</v-btn>
          <v-btn color="primary" depressed :disabled="!valid" :loading="loading" @click="handleSubmit">Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "CategoryEdit",
  props: ['open', 'id'],
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
        is_published: false,
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
  watch: {
    open: function (newVal, oldVal) {
      if (newVal === true) {
        this.fetchCategoryDetail()
      } else {
        this.formEditCategory = {
          name: '',
          file: null,
          description: '',
          parent: null,
          updated_at: '',
          updated_by: '',
          is_published: false,
          is_navbar: false
        }
      }
    }
  },
  created () {
    this.fetchParentCategories()
  },
  methods: {
    handleClose () {
      this.$emit('close')
    },
    async fetchCategoryDetail () {
      this.loading = true
      this.$store.dispatch('category/adminFetchCategory', { category_id: this.id }).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.formEditCategory.name = result.data.name
          this.formEditCategory.description = result.data.description
          this.formEditCategory.parent = result.data.parent
          this.formEditCategory.updated_at = new Date(result.data.updated_at).toLocaleDateString('id-ID')
          this.formEditCategory.updated_by = result.data.updated_by
          this.formEditCategory.is_published = result.data.is_published === 1 ? true : false
          this.formEditCategory.is_navbar = result.data.is_navbar === 1 ? true : false
          this.thumbnail = result.data.file_path
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
    async handleSubmit () {
      this.loading = true
      let formData = new FormData()
      if (this.formEditCategory.file) {
        formData.append('file', this.formEditCategory.file, this.formEditCategory.file.name)
      } else {
        let blob = await fetch(this.thumbnail).then(res => res.blob())
        console.log(blob)
        let file = new Blob([blob], { type: blob.type })
        console.log(file)
        formData.append('file', file, this.formEditCategory.name)
        debugger
      }
      if (!this.formEditCategory.parent || this.formEditCategory.parent === 'null') {
        this.formEditCategory.parent = ''
      }
      formData.append('name', this.formEditCategory.name)
      formData.append('description', this.formEditCategory.description)
      formData.append('parent', this.formEditCategory.parent)
      formData.append('is_published', this.formEditCategory.is_published ? 1 : 0)
      formData.append('is_navbar', this.formEditCategory.is_navbar ? 1 : 0)
      this.$store.dispatch('category/adminUpdateCategory', {
        category_id: this.id,
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
        this.handleClose()
      })
    }
  }
}
</script>

<style scoped>

</style>
