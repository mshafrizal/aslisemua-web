/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';

Vue.use(VueRouter);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('app', require('./components/App.vue').default);

import App from './App.vue'
import Dashboard from './views/Dashboard.vue'

import CustomerList from './views/customer/CustomerList.vue'
import CustomerDetail from './views/customer/CustomerDetail.vue'

const routes = [
    {
        path: '/admin/dashboard', name: 'dashboard', component: Dashboard
    },
    {
        path: '/admin/customer/list', name: 'customer-list', component: CustomerList
    },
    {
        path: '/admin/customer/detail', name: 'customer-detail', component: CustomerDetail
    },

]

const router = new VueRouter({
    mode: 'history',
    routes
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
