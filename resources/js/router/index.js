import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index'

Vue.use(VueRouter)

import Dashboard from '../views/Dashboard.vue'
import SignIn from '../views/SignIn.vue'

import CustomerList from '../views/customer/CustomerList.vue'
import CustomerDetail from '../views/customer/CustomerDetail.vue'

import BrandList from "../views/brand/BrandList.vue"
import BrandCreate from "../views/brand/BrandCreate.vue"

const routes = [
  {
    path: '/admin/signin', name: 'sign-in', component: SignIn, meta: { requiresAuth: false }
  },
  {
    path: '/admin/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true }
  },
  {
    path: '/admin/customer/list', name: 'customer-list', component: CustomerList, meta: { requiresAuth: true }
  },
  {
    path: '/admin/customer/:id/detail', name: 'customer-detail', component: CustomerDetail, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brands', name: 'brand-list', component: BrandList, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brands/create', name: 'brand-create', component: BrandCreate, meta: { requiresAuth: true }
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if(to.meta.requiresAuth) {
    let isAuthenticated = store.getters['auth/authLoggedIn']
    if (isAuthenticated) {
      next()
    } else {
      next({ name: 'sign-in' })
    }
  } else {
    next()
  }
})

export default router
