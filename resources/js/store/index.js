import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import brand from './modules/brand'
import customer from "./modules/customer"
import category from "./modules/category"
import product from './modules/product'
Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const state = {
  snackbar: null
}
const mutations = {
  setSnackbar (state, payload) {
    state.snackbar = payload
  }
}
const actions = {
  showSnackbar (context, payload) {
    context.commit('setSnackbar', payload)
  }
}
const getters = {
  getSnackbar: (state) => {
    return state.snackbar
  }
}

export default new Vuex.Store({
  state: state,
  mutations: mutations,
  getters: getters,
  actions: actions,
  modules: {
    auth,
    brand,
    customer,
    category,
    product
  }
})

