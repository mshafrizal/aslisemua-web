require('./bootstrap');

window.Vue = require('vue').default;
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';

Vue.use(Vuetify);
Vue.use(VueRouter);

import App from './App.vue'
import Dashboard from './views/Dashboard.vue'

import CustomerList from './views/customer/CustomerList.vue'
import CustomerDetail from './views/customer/CustomerDetail.vue'
// import Vue from 'vue';

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
        router,
        vuetify: new Vuetify()
    });
}