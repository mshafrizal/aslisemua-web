import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import brand from './modules/brand'
import customer from "./modules/customer"
import category from "./modules/category"
import product from './modules/product'
import cart from './modules/cart'
import customerAddress from './modules/customerAddress'
import filter from './modules/filter'
import paymentType from './modules/paymentType'
// import createPersistedState from 'vuex-persistedstate'
Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const state = {
  snackbar: []
}
const mutations = {
  setSnackbar (state, payload) {
    state.snackbar.push(payload)
  },
  removeMessage (state, payload) {
    const index = state.snackbar.findIndex(item => item.id === payload)
    if (index !== -1) {
      state.snackbar.splice(index, 1)
    }
  }
}
const actions = {
  // payload = {
  //   message: String,
  //   color: String
  // }
  showSnackbar (context, payload) {
    context.commit('setSnackbar', { id: `snackbar_` +
        Math.random()
          .toString(36)
          .substr(2, 9), ...payload})
  },
  // paylad = id
  removeSnackbarMessage (context, payload) {
    context.commit('removeMessage', payload)
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
    product,
    cart,
    customerAddress,
    filter,
    paymentType,
  }
})

