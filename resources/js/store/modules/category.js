const state = () => ({})
const getters = {}
const actions = {
  adminCreateCategory (context, payload) {
    return axios.post(`/api/v1/categories/private`, payload).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminFetchCategories (context, payload) {
    return axios.get(`/api/v1/categories/private`, payload).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminFetchCategory (context, payload) {
    return axios.get(`/api/v1/categories/private/${payload.category_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminUpdateCategory (context, payload) {
    return axios.post(`/api/v1/categories/private/update/${payload.category_id}`, payload.data).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminUpdateCategoryStatus (context, payload) {
    return axios.post(`/api/v1/categories/private/update/status/${payload.category_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminDeleteCategory (context, payload) {
    return axios.post(`/api/v1/categories/private/delete/${payload.category_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  adminBulkDeleteCategories (context, payload) {
    return axios.post(`/api/v1/categories/private/delete/bulk`, payload).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  fetchCategories (context, query) {
    return axios.get(`/api/v1/categories/public/${query}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
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
