import axios from "axios"

export default {
  namespaced: true,
  state: () => ({
    loading: false,
  }),
  getters: {
    isConsignmentLoading (state) {
      return state.loading
    },
  },
  actions: {
      updateConsignmentLoading ({ commit }, payload) {
          commit('setLoading', payload)
      },
      adminGetConsignmentRequestList(context, payload) {
          return axios.get(`/api/v1/consignments/private/`)
          .then((response) => Promise.resolve(response.data))
          .catch(error => Promise.reject(error))
          .finally(() => context.commit('setLoading', false))
      }
  },
  mutations: {
    setLoading (state, payload) {
      state.loading = payload
    }
  }
}
