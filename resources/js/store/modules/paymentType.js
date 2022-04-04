import axios from "axios"

const state = {
    paymentTypes: [],
    isFetching: true,
    isSubmitting: false,
}             
const getters = {
    getPaymentTypes: (state) => state.paymentTypes,
    getPaymentTypeLoading: (state) => state.isFetching,
    getPaymentTypeIsSubmitting: (state) => state.isSubmitting,
}     
const actions = {
    updatePaymentTypes: ({ commit }, PaymentTypes) => commit('setPaymentTypes', PaymentTypes),
    updatePaymentTypeLoading: ({ commit }, PaymentTypeLoading) => commit('setPaymentTypeLoading', PaymentTypeLoading),
    updatePaymentTypeIsSubmitting: ({ commit }, PaymentTypeIsSubmitting) => commit('setPaymentTypeIsSubmitting', PaymentTypeIsSubmitting),
    async fetchPaymentTypes ({ commit, state }, payload) {
        commit('setPaymentTypes', [])
        commit('setPaymentTypeLoading', true)
        await axios.get('/api/v1/payments-types')
            .then(response => {
                commit('setPaymentTypes', response.data.results)
                return Promise.resolve(response)
            })
            .catch(error => {
                return Promise.reject(error);
            }).finally(() => {
                commit('setPaymentTypeLoading', false)
            })
    },
    storePaymentType({ commit }, payload) {
        commit('setPaymentTypeIsSubmitting', true)
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/payments-types/', payload)
                .then(response => resolve(response))
                .catch(error => reject(error))
                .finally(() => commit('setPaymentTypeIsSubmitting', false))
        })
    },
    updatePaymentType({ commit }, payload) {
        commit('setPaymentTypeIsSubmitting', true)
        return new Promise((resolve, reject) => {
            axios.put(`/api/v1/payments-types/${payload.id}`, payload)
                .then(response => resolve(response))
                .catch(error => reject(error))
                .finally(() => commit('setPaymentTypeIsSubmitting', false))
        })
    },
    deletePaymentType({ commit }, id) {
        commit('setPaymentTypeIsSubmitting', true)
        return new Promise((resolve, reject) => {
            axios.delete(`/api/v1/payments-types/${id}`)
                .then(response => resolve(response))
                .catch(error => reject(error))
                .finally(() => commit('setPaymentTypeIsSubmitting', false))
        })
    },
    storeBank({ commit }, payload) {
        commit('setPaymentTypeisSubmitting', true)
        return new Promise((resolve, reject) => {
            axios.post(`/api/v1/banks/private/`, payload)
                .then(response => resolve(response))
                .catch(error => reject(error))
                .finally(() => commit('setPaymentTypeIsSubmitting', false))
        })
    }
    
}
const mutations = {
    setPaymentTypes: (state, paymentTypes) => state.paymentTypes = paymentTypes,
    setPaymentTypeLoading: (state, paymentTypeLoading) => state.isFetching = paymentTypeLoading,
    setPaymentTypeIsSubmitting: (state, paymentTypeIsSubmitting) => state.isSubmitting = paymentTypeIsSubmitting,
}
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }