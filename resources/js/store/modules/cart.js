import axios from "axios"

export default {
  namespaced: true,
  state: () => ({
    cart: [],
  }),
  getters: {
    getCart (state) {
      return state.cart
    },
    getTotalItem (state) {
      return state.cart.length
    }
  },
  actions: {
    checkProduct ({ state }, payload) {
      return state.cart.findIndex(product => product.id === payload.id) > -1
    },
    addToCart ({ commit }, payload) {
      commit('pustToCart', payload)
    },
    insertProduct (context, payload) {
      return axios.post(`/api/v1/carts/store`, { product_id: payload }).then(response => {
        return Promise.resolve(response.data)
      }).catch(error => Promise.reject(error))
    },
    deleteProduct (context, payload) {
      return axios.delete(`/api/v1/carts/delete`, { data: { product_id: payload } }).then(response => {
        return Promise.resolve(response.data)
      }).catch(error => Promise.reject(error))
    },
    getProducts (context, payload) {
      return axios.get(`/api/v1/carts/`).then(response => {
        return Promise.resolve(response.data)
      }).catch(error => Promise.reject(error))
    }
  },
  mutations: {
    pushToCart (state, payload) {
      state.cart.push(payload)
    }
  }
}
