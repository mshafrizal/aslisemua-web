<template>
  <div id="sidebar" class="flex flex-col p-4 border w-240">
    <template v-for="(menu, index) in menus">
      <router-link :to="menu.link" v-if="menu.link" :key="menu.name">
        <div class="menu-item flex items-center p-2" @click="closeChildMenu">
          <div class="inline mr-2" v-html="menu.icon"></div>
          <span>{{ menu.name }}</span>
        </div>
      </router-link>
      <div class="menu-item flex flex-col" v-else :key="menu.name">
        <div class="flex justify-between items-center p-2" @click="toggleChildMenu(menu.name, index)">
          <div class="flex items-center">
            <div class="inline mr-2" v-html="menu.icon"></div>
            <div>{{ menu.name }}</div>
          </div>
          <svg v-if="activeParent === index" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          <svg v-else class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </div>
        <template v-for="child in menu.children">
          <router-link :class="activeParent === index ? 'child-menu-item p-2 ml-8' : 'hidden'" :to="child.link" :key="child.name">
            {{ child.name }}
          </router-link>
        </template>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: 'SidebarComponent',
  data: function () {
    return {
      activeParent: null,
      menus: [
        {
          name: 'Dashboard',
          link: '/admin/dashboard',
          icon: `<svg class="w-6 h-6 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>`
        },
        {
          name: 'Customer',
          link: '/admin/customer/list',
          icon: `<svg class="w-6 h-6 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>`
        },
        {
          name: 'Master Product',
          icon: `<svg class="w-6 h-6 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>`,
          children: [
            { name: 'Products', link: '/admin/master-product/products' },
            { name: 'Brands', link: '/admin/master-product/brands' },
            { name: 'Categories', link: '/admin/master-product/categories' }
          ]
        },
        {
          name: 'Orders',
          link: '/admin/orders',
          icon: `<svg class="w-6 h-6 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`
        },
        {
          name: 'Shipment',
          link: '/admin/shipment',
          icon: `<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path fill="#fff" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>`
        },
        {
          name: 'Content',
          icon: `<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>`
        },
      ]
    }
  },
  methods: {
    closeChildMenu () {
      this.activeParent = null
    },
    toggleChildMenu (menu, index) {
      if (this.activeParent === index) {
        this.activeParent = null
      } else {
        this.activeParent = index
      }
    }
  }
}
</script>

<style scoped>
.w-240 {
  width: 240px;
}
.router-link-exact-active,
.parent-active {
  background-color: #14B8A6;
  color: #fff;
}
.router-link-exact-active div svg.text-primary-admin {
  color: '#fff'
}
</style>