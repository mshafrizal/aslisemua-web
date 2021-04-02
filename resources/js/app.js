/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const userMenuButton = document.getElementById('user-menu');
const userMenuDropdown = document.getElementById('user-menu-list');
const signOutButton = document.getElementById('sign-out-button');

if (userMenuButton && userMenuDropdown) {
    userMenuButton.addEventListener('click', () => {
        if (userMenuDropdown.classList.contains('hidden')) userMenuDropdown.classList.replace('hidden', 'block');
        else userMenuDropdown.classList.replace('block', 'hidden');
    });
}

if (signOutButton) {
    signOutButton.addEventListener('click', function () {
        localStorage.setItem('google_id', '');
        localStorage.setItem('gender', '');
        localStorage.setItem('district', '');
        localStorage.setItem('email_verified_at', '');
        localStorage.setItem('id', '');
        localStorage.setItem('address', '');
        localStorage.setItem('status', '');
        localStorage.setItem('level', '');
        localStorage.setItem('city', '');
        localStorage.setItem('name', '');
        localStorage.setItem('is_verified', '');
        localStorage.setItem('created_at', '');
        localStorage.setItem('updated_at', '');
        localStorage.setItem('postal_code', '');
        localStorage.setItem('phone_number', '');
        localStorage.setItem('is_first_time', '');
        localStorage.setItem('email', '');
        localStorage.setItem('token', '');
        window.location.href = '/sign-in'
    });
}
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
if (document.location.href.includes('admin')) {
    const app = new Vue({
        el: '#app',
        components: { App },
        router
    });
}