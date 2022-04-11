import axios from "axios"

const state = () => ({})
const getters = {}
const actions = {
  createBrand (context, payload) {
    return axios.post(`/api/v1/brands`, payload).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  fetchBrands (context, payload) {
    return axios.get(`/api/v1/brands`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  fetchBrandsPublic (context, payload) {
    return axios.get(`/api/v1/brands/public`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  fetchBrand (context, payload) {
    return axios.get(`/api/v1/brands/${payload.brand_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  updateBrand (context, payload) {
    return axios.post(`/api/v1/brands/${payload.brand_id}`, payload.data).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  deleteBrand (context, payload) {
    return axios.delete(`/api/v1/brands/${payload.brand_id}`).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  searchBrands (context, keyword) {
    return axios.get(`/api/v1/brands/search`, {keyword: keyword}).then(response => {
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  fetchAllBrands (context, payload) {
    return axios.get(`/api/v1/brands/all`).then(response => {
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
