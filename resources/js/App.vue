<template>
  <div class="flex flex-col">
    <header-component />
    <div class="flex flex-row">
      <sidebar-component />
      <div class="p-3">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue'
import Header from './components/Header.vue'

export default {
  name: 'App',
  components: {
    'sidebar-component': Sidebar,
    'header-component': Header
  },
  mounted () {
    console.log(this.$route)
  }
}
</script>

<style>

</style>