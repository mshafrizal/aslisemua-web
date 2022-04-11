import axios from "axios"

const state = () => ({})
const getters = {}
const actions = {
  adminFetchProducts (context, payload) {
    return axios.get(`/api/v1/products/private`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminDeleteProduct (context, payload) {
    return axios.delete(`/api/v1/products/private/${payload.product_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminFetchProduct (context, payload) {
    return axios.get(`/api/v1/products/private/${payload.product_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminCreateProduct (context, payload) {
    return axios.post(`/api/v1/products/private/create`, payload).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminEditProduct (context, payload) {
    return axios.post(`/api/v1/products/private/${payload.product_id}/update`, payload.data).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  }
}
const mutations = {}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
