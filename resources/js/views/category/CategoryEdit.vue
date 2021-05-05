<template>
  <v-row>
    <v-col cols="12">Create Category</v-col>
    <v-col cols="12" sm="4">
      <v-card>
        <v-form ref="formCreateCategory" v-model="valid">
          <v-card-title>Category Thumbnail</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-img :src="fileUrl" contain max-width="150" max-height="150"></v-img>
            <v-file-input
              v-model="formCreateCategory.file"
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
              v-model.trim="formCreateCategory.name"
              :rules="nameRules"
              label="Name"
              name="name"
              required
            ></v-text-field>
            <v-textarea
              name="description"
              label="Description"
              v-model.trim="formCreateCategory.description"
              :rules="[v => !!v || 'Please provide meaningful description']"
              required
            ></v-textarea>
            <v-select
              :items="parentCategory"
              label="Parent Category"
              item-text="name"
              item-value="id"
              v-model="formCreateCategory.parents"
              hint="Select parent category if you wish this category to be sub category"
            ></v-select>
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
      formCreateCategory: {
        name: '',
        file: null,
        description: '',
        parents: null
      },
      loading: false,
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length > 3) || 'Name must be more than 3 characters',
      ],
      fileRules: [
        value => !!value || 'This field is required',
        value => !value || value.size < 2000000 || 'Thumbnail size should be less than 2 MB!',
      ],
      parentCategory: []
    }
  },
  computed: {
    fileUrl () {
      if (!this.formCreateCategory.file) return
      return URL.createObjectURL(this.formCreateCategory.file)
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
          this.category = result.data
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
      formData.append('file', this.formCreateCategory.file, this.formCreateCategory.file.name)
      formData.append('name', this.formCreateCategory.name)
      formData.append('description', this.formCreateCategory.description)
      formData.append('parents', this.formCreateCategory.parents)
      this.$store.dispatch('category/adminCreateCategory', formData).then(result => {
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
        this.formCreateCategory = {
          name: '',
          file: null,
          description: '',
          parents: null
        }
        this.$router.push('/admin/category/list')
      })
    }
  }
}
</script>

<style scoped>

</style>
