const state = () => ({})
const getters = {}
const actions = {
  createBrand (context, payload) {
    debugger
    return axios.post(`${process.env.MIX_APP_URL}/api/v1/brands`, payload).then(response => {
      return response
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
