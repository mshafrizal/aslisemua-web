import axios from "axios"

export default {
  namespaced: true,
  actions: {
    // Change Status Active Address
    async changeActiveAddress (context, payload) {
      try {
        return await axios.put(`api/v1/customer-address/address/status`, payload)
      } catch (error) {
        return error
      }
    },
    // Update Customer Address
    async updateAddress (context, payload) {
      try {
        return await axios.put(`/api/v1/customer-address/${payload.customer_id}/address/${payload.address_id}`, payload.body)
      } catch (error) {
        return error
      }
    },
    // Delete Customer Address
    async deleteAddress (context, payload) {
      try {
        return await axios.delete(`/api/v1/customer-address/${payload.customer_id}/address/${payload.address_id}/delete`)
      } catch (error) {
        return error
      }
    }
  }
}