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
import BrandEdit from "../views/brand/BrandEdit";

import CategoryList from "../views/category/CategoryList";
import CategoryCreate from "../views/category/CategoryCreate";
import CategoryEdit from "../views/category/CategoryEdit";

import ProductList from "../views/product/ProductList";
import ProductCreate from "../views/product/ProductCreate";

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
    path: '/admin/customer/:id/edit', name: 'customer-edit', component: CustomerDetail, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brand/list', name: 'brand-list', component: BrandList, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brand/create', name: 'brand-create', component: BrandCreate, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brand/:id/detail', name: 'brand-detail', component: BrandCreate, meta: { requiresAuth: true }
  },
  {
    path: '/admin/brand/:id/edit', name: 'brand-edit', component: BrandCreate, meta: { requiresAuth: true }
  },
  {
    path: '/admin/category/list', name: 'category-list', component: CategoryList, meta: { requiresAuth: true }
  },
  {
    path: '/admin/category/create', name: 'category-create', component: CategoryCreate, meta: { requiresAuth: true }
  },
  {
    path: '/admin/category/:id/edit', name: 'category-edit', component: CategoryEdit, meta: { requiresAuth: true }
  },
  {
    path: '/admin/product/list', name: 'product-list', component: ProductList, meta: { requiresAuth: true }
  },
  {
    path: '/admin/product/create', name: 'product-create', component: ProductCreate, meta: { requiresAuth: true }
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    console.log(store.getters["auth/authLoggedIn"])
    if (!store.getters["auth/authLoggedIn"]) {
      next('/admin/signin')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
