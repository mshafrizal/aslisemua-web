<template>
  <div>
    <div class="text-lg font-weight-bold">Categories</div>
    <v-treeview
      :active="categories.active"
      activatable
      dense
      item-key="id"
      return-object
      :items="items"
      @update:active="getActiveValue"
    ></v-treeview>
  </div>
</template>

<script>
export default {
  name: 'CategoriesFilter',
  props: ['items'],
  data: function () {
    return {
      categories: {
        active: [],
        selected: null
      }
    }
  },
  mounted () {
  },
  methods: {
    getActiveValue (val) {
      this.$emit('selected', val[0])
    }
  }
}
</script>

<style>

</style>