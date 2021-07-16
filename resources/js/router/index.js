import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index'
Vue.use(VueRouter)

// admin

import AdminLayout from "../views/AdminLayout";

import Dashboard from '../views/admin/Dashboard.vue'
import SignIn from '../views/admin/SignIn.vue'

import CustomerList from '../views/admin/customer/CustomerList.vue'
import CustomerDetail from '../views/admin/customer/CustomerDetail.vue'

import BrandList from "../views/admin/brand/BrandList.vue"
import BrandCreate from "../views/admin/brand/BrandCreate.vue"
import BrandEdit from "../views/admin/brand/BrandEdit";

import CategoryList from "../views/admin/category/CategoryList";
import CategoryCreate from "../views/admin/category/CategoryCreate";
import CategoryEdit from "../views/admin/category/CategoryEdit";

import ProductList from "../views/admin/product/ProductList";
import ProductCreate from "../views/admin/product/ProductCreate";
import ProductDetail from "../views/admin/product/ProductDetail";

// user

import UserLayout from "../views/UserLayout";

import Homepage from "../views/user/Homepage";
const routes = [
  {
    path: '/admin',
    component: AdminLayout,
    name: 'admin',
    meta: { requiresAuth: false },
    children: [
      {
        path: '/signin', name: 'sign-in', component: SignIn, meta: { requiresAuth: false }
      },
      {
        path: '/', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true }
      },
      {
        path: '/customer/list', name: 'customer-list', component: CustomerList, meta: { requiresAuth: true }
      },
      {
        path: '/customer/:id/detail', name: 'customer-detail', component: CustomerDetail, meta: { requiresAuth: true }
      },
      {
        path: '/customer/:id/edit', name: 'customer-edit', component: CustomerDetail, meta: { requiresAuth: true }
      },
      {
        path: '/brand/list', name: 'brand-list', component: BrandList, meta: { requiresAuth: true }
      },
      {
        path: '/brand/create', name: 'brand-create', component: BrandCreate, meta: { requiresAuth: true }
      },
      {
        path: '/brand/:id/detail', name: 'brand-detail', component: BrandCreate, meta: { requiresAuth: true }
      },
      {
        path: '/brand/:id/edit', name: 'brand-edit', component: BrandCreate, meta: { requiresAuth: true }
      },
      {
        path: '/category/list', name: 'category-list', component: CategoryList, meta: { requiresAuth: true }
      },
      {
        path: '/category/create', name: 'category-create', component: CategoryCreate, meta: { requiresAuth: true }
      },
      {
        path: '/category/:id/edit', name: 'category-edit', component: CategoryEdit, meta: { requiresAuth: true }
      },
      {
        path: '/product/list', name: 'product-list', component: ProductList, meta: { requiresAuth: true }
      },
      {
        path: '/product/create', name: 'product-create', component: ProductCreate, meta: { requiresAuth: true }
      },
      {
        path: '/product/:id/detail', name: 'product-detail', component: ProductDetail, meta: { requiresAuth: true }
      },
    ]
  },
  {
    path: '/',
    component: UserLayout,
    meta: { requiresAuth: false },
    children: [
      {
        path: '',
        component: Homepage,
        name: 'Homepage',
        meta: { requiresAuth: false }
      }
    ]
  }
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
