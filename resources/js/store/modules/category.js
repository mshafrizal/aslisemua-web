const state = () => ({})
const getters = {}
const actions = {
  adminCreateCategory (context, payload) {
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/categories/private`, payload).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminFetchCategories (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/categories/private`, payload).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminFetchCategory (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/categories/private/${payload.category_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminUpdateCategory (context, payload) {
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/categories/private/update/${payload.category_id}`, payload.data).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminUpdateCategoryStatus (context, payload) {
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/categories/private/update/status/${payload.category_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminDeleteCategory (context, payload) {
    return axios.delete(`${process.env.MIX_APP_URL}/api/v1/categories/private/delete/${payload.category_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  adminBulkDeleteCategories (context, payload) {
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/categories/private/delete/bulk`, payload).then(response => {
      return response.data
    }).catch(error => error)
  },
  fetchCategories (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/categories/public`).then(response => {
      return response.data
    }).catch(error => error)
  },
}
const mutations = {}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
