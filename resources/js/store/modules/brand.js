const state = () => ({})
const getters = {}
const actions = {
  createBrand (context, payload) {
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/brands`, payload).then(response => {
      return response.data
    }).catch(error => error)
  },
  fetchBrands (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/brands`).then(response => {
      return response.data
    }).catch(error => error)
  },
  fetchBrand (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/brands/${payload.brand_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  updateBrand (context, payload) {
    return axios.get(`${process.env.MIX_APP_URL}/api/v1/brands/${payload.brand_id}`).then(response => {
      return response.data
    }).catch(error => error)
  },
  deleteBrand (context, payload) {
    return axios.delete(`${process.env.MIX_APP_URL}/api/v1/brands/${payload.brand_id}`).then(response => {
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
