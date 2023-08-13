import axios from 'axios'
const state = () => ({})
const getters = {}
const actions = {
  async adminCreateCategory (context, payload) {
    try {
      const response = await axios.post(`/api/v1/categories/private`, payload)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminFetchCategories (context, payload) {
    try {
      const response = await axios.get(`/api/v1/categories/private`, payload)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminFetchCategory (context, payload) {
    try {
      const response = await axios.get(`/api/v1/categories/private/${payload.category_id}`)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminUpdateCategory (context, payload) {
    try {
      const response = await axios.post(`/api/v1/categories/private/update/${payload.category_id}`, payload.data)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminUpdateCategoryStatus (context, payload) {
    try {
      const response = await axios.put(`/api/v1/categories/private/update/status/${payload.category_id}`, { status: payload.status })
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminDeleteCategory (context, payload) {
    try {
      const response = await axios.post(`/api/v1/categories/private/delete/${payload.category_id}`)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async adminBulkDeleteCategories (context, payload) {
    try {
      const response = await axios.post(`/api/v1/categories/private/delete/bulk`, payload)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
  },
  async fetchCategories (context, query) {
    try {
      const response = await axios.get(`/api/v1/categories/public/${query}`)
      return await Promise.resolve(response.data)
    } catch (error) {
      return await Promise.reject(error)
    }
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
