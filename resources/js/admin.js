require('./bootstrap');

window.Vue = require('vue').default;
import Vuetify from 'vuetify';
import Vuex from 'vuex';

Vue.use(Vuetify);
Vue.use(Vuex);
Vue.prototype.$axios = axios

import store from './store/index'
import App from './App.vue'
import router from "./router"
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
        store,
        vuetify: new Vuetify()
    });
}
