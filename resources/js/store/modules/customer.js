const state = () => ({})
const getters = {}
const actions = {
  fetchCustomers (context, payload) {
    return axios.get(`/api/v1/customers`).then(response => {
      return response.data
    }).catch(error => error)
  },
  fetchCustomer (context, payload) {
    return axios.get(`/api/v1/customers/${payload.customer_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  updateCustomer (context, payload) {
    return axios.get(`/api/v1/customers/${payload.customer_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  deleteCustomer (context, payload) {
    return axios.delete(`/api/v1/customers/${payload.customer_id}`).then(response => {
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
