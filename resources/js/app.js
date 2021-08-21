require('./bootstrap');

window.Vue = require('vue').default;
import Vuetify from 'vuetify';
import Vuex from 'vuex';
import VCurrencyField from "v-currency-field";
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/css/swiper.min.css'
// Vuetify's CSS styles
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
// don't forget to import CSS styles
import 'tiptap-vuetify/dist/main.css'
import VuetifySnackbarQueue from 'vuetify-snackbar-queue'

Vue.use(VuetifySnackbarQueue)
const vuetify = new Vuetify()

Vue.use(VueAwesomeSwiper, /* { default options with global component } */)
Vue.use(Vuetify);
Vue.use(VCurrencyField, {
  locale: 'id-ID',
  decimalLength: 0,
  autoDecimalMode: false,
  min: null,
  max: null,
  defaultValue: 0,
  valueAsInteger: true,
  allowNegative: true
})
Vue.use(Vuex);
Vue.use(TiptapVuetifyPlugin, {
  vuetify, iconsGroup: 'mdi'
})
Vue.prototype.$axios = axios

import store from './store/index'
import App from './App.vue'
import router from "./router"
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
  el: '#userApp',
  router,
  store,
  vuetify,
  beforeCreate() {
    this.$store.commit('auth/initializeAuthStore')
  },
  render: h => h(App)
});
