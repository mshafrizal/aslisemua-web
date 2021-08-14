const state = () => ({})
const getters = {}
const actions = {
  adminFetchProducts (context, payload) {
    return axios.get(`/api/v1/products/private/`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminDeleteProduct (context, payload) {
    return axios.delete(`/api/v1/products/private/${payload.product_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminFetchProduct (context, payload) {
    return axios.get(`/api/v1/products/private/${payload.product_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminCreateProduct (context, payload) {
    return axios.post(`/api/v1/products/private/create`, payload).then(response => {
      return response.data
    }).catch(error => error)
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
