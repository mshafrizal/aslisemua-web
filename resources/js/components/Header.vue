<template>
  <div class="flex flex-row justify-between p-4 border bg-admin">
    <div class="flex text-white">
      <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <router-link to="/admin/dashboard">ASLISEMUA</router-link>
    </div>
    <div class="flex">Avatar</div>
  </div>
</template>

<script>
export default {
  name: 'HeaderComponent'
}
</script>

<style>

</style>