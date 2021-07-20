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
import Login from "../views/user/Login";
import Register from "../views/user/Register";
import ForgotPassword from "../views/user/ForgotPassword";
import IndexProfile from "../views/user/profile/IndexProfile";
import PersonalInfo from "../views/user/profile/PersonalInfo";
const routes = [
  {
    path: '/admin',
    component: AdminLayout,
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
        meta: { requiresAuth: false, navbar: true }
      },
      {
        path: '/login',
        component: Login,
        name: 'LoginUser',
        meta: { requiresAuth: false, navbar: false }
      },
      {
        path: '/register',
        component: Register,
        name: 'RegisterUser',
        meta: { requiresAuth: false, navbar: false }
      },
      {
        path: '/forgot-password',
        component: ForgotPassword,
        name: 'ForgotPassword',
        meta: { requiresAuth: false, navbar: false }
      },
      {
        path: '/profile',
        component: IndexProfile,
        meta: { requiresAuth: true, navbar: true }
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
    if (!localStorage.getItem('token')) {
      next('/login')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
