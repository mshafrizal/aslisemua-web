<template>
  <v-dialog
    v-model="open"
    max-width="400"
    persistent
  >
    <v-card v-if="loading">
      <v-skeleton-loader
        class="mx-auto"
        max-width="400"
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-card v-else>
      <v-form ref="formCreateCategory" v-model="valid" @submit.prevent="handleSubmit">
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
            clearable
            hint="Select parent category if you wish this category to be sub category"
          ></v-select>
          <v-checkbox v-model="formCreateCategory.is_navbar" label="Add to navigation bar"></v-checkbox>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="error" text :disabled="loading" @click="close">Cancel</v-btn>
          <v-btn color="primary" depressed :disabled="!valid" :loading="isSubmitting" type="submit">Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "CategoryCreate",
  props: {
    open: Boolean
  },
  data: function () {
    return {
      isSubmitting: false,
      valid: true,
      formCreateCategory: {
        name: '',
        file: null,
        description: '',
        parents: null,
        is_navbar: false
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
    this.fetchParentCategories()
  },
  methods: {
    close () {
      this.formCreateCategory =  {
        name: '',
        file: null,
        description: '',
        parents: null,
        is_navbar: false
      }
      this.$emit('close')
    },
    fetchParentCategories () {
      this.loading = true
      this.formCreateCategory = {
        name: '',
        file: null,
        description: '',
        parents: null,
        is_navbar: false
      }
      this.$store.dispatch('category/adminFetchCategories').then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.parentCategory = result.data
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          color: 'error',
          message: error
        })
      }).finally(() => {
        this.loading = false
      })
    },
    handleSubmit () {
      this.isSubmitting = true
      let formData = new FormData()
      formData.append('file', this.formCreateCategory.file, this.formCreateCategory.file.name)
      formData.append('name', this.formCreateCategory.name)
      formData.append('description', this.formCreateCategory.description)
      formData.append('parent', this.formCreateCategory.parents)
      formData.append('is_navbar', this.formCreateCategory.is_navbar ? 1 : 0)
      this.$store.dispatch('category/adminCreateCategory', formData).then(result => {
        if (result.status >= 400) throw new Error(result.message)
        else {
          this.$store.dispatch('showSnackbar', {
            color: 'success',
            message: result.message
          })
        }
        this.close()
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          color: 'error',
          message: error
        })
      }).finally(() => {
        this.isSubmitting = false
        this.formCreateCategory =  {
          name: '',
          file: null,
          description: '',
          parents: null,
          is_navbar: false
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
