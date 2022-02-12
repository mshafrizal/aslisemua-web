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
        await axios.get('/api/v1/payment-types')
        .then(response => commit('setPaymentTypes', response.data))
        .catch(error => {
            console.log('error', error)
        }).finally(() => {
            commit('setPaymentTypeLoading', false)
        })
    },
    storePaymentType({ commit }, payload) {
        commit('setPaymentTypeIsSubmitting', true)
        return new Promise((resolve, reject) => {
            axios.post('/api/v1/payment-types', payload)
                .then(response => resolve(response))
                .catch(error => reject(error))
                .finally(() => commit('setPaymentTypeIsSubmitting', false))
        })
    }
}
const mutations = {
    setpaymentTypes: (state, paymentTypes) => state.paymentTypes = paymentTypes,
    setpaymentTypeLoading: (state, paymentTypeLoading) => state.paymentTypeLoading = paymentTypeLoading,
    setpaymentTypeIsSubmitting: (state, paymentTypeIsSubmitting) => state.paymentTypeIsSubmitting = paymentTypeIsSubmitting,
}
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }