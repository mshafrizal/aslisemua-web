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
  },
  fetchAddresses (context, payload) {
    const userData = JSON.parse(localStorage.getItem('user'))
    return axios.get(`/api/v1/customer-address/${userData.id}`).then(response => {
      return response.data
    }).catch(error => Promise.reject(error))
  },
  AddAddress (context, payload) {
    const userData = JSON.parse(localStorage.getItem('user'))
    return axios.post(`/api/v1/customer-address`, { customer_id: userData.id , ...payload}).then(response => {
      return response.data
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
