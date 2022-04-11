import axios from "axios"

const state = {
    provinceList: [],
    provinceLoading: true,
    provinceIsSubmitting: false,
    cityList: [],
    cityIsSubmitting: false,
    cityLoading: true,
    districtList: [],
    districtLoading: true,
    districtIsSubmitting: false,
}             
const getters = {
    getProvinces: (state) => state.provinceList,
    getProvinceLoading: (state) => state.provinceLoading,
    getProvinceIsSubmitting: (state) => state.provinceIsSubmitting,
    getCities: (state) => state.Cities,
    getCityLoading: (state) => state.CityLoading,
    getCityIsSubmitting: (state) => state.order_by,
    getDistricts: (state) => state.Districts,
    getDistrictLoading: (state) => state.DistrictLoading,
    getDistrictIsSubmitting: (state) => state.clothing_size,
}     
const actions = {
    updateProvinces: ({ commit }, Provinces) => commit('setProvinces', Provinces),
    updateProvinceLoading: ({ commit }, ProvinceLoading) => commit('setProvinceLoading', ProvinceLoading),
    updateProvinceIsSubmitting: ({ commit }, ProvinceIsSubmitting) => commit('setProvinceIsSubmitting', ProvinceIsSubmitting),
    updateCities: ({ commit }, Cities) => commit('setCities', Cities),
    updateCityLoading: ({ commit }, CityLoading) => commit('setCityLoading', CityLoading),
    updateCityIsSubmitting: ({ commit }, CityIsSubmitting) => commit('setCityIsSubmitting', CityIsSubmitting),
    updateDistricts: ({ commit }, Districts) => commit('setDistricts', Districts),
    updateDistrictLoading: ({ commit }, DistrictLoading) => commit('setDistrictLoading', DistrictLoading),
    updateDistrictIsSubmitting: ({ commit }, DistrictIsSubmitting) => commit('setDistrictIsSubmitting', DistrictIsSubmitting),
    async fetchProvinces ({ commit, state }, payload) {
        commit('setProvinces', [])
        commit('setProvinceLoading', true)
        await axios.get('/api/v1/region/public/province')
        .then(response => commit('setProvinces', response.data))
        .catch(error => {
            console.log('error', error)
        }).finally(() => {
            commit('setProvinceLoading', false)
        })
    },
    async fetchCities ({ commit }, payload) {
        commit('setCities', [])
        commit('setCityLoading', true)
        await axios.get('/api/v1/region/public/city')
        .then(response => commit('setCities', response.data))
        .catch(error => console.log('error', error))
        .finally(() => commit('setCityLoading', false))
    },
    async fetchDistricts ({commit}, payload) {
        commit('setDistricts', [])
        commit('setDistrictLoading', true)
        await axios.get('/api/v1/region/public/district')
        .then(response => commit('setDistricts', response.data))
        .catch(error => console.log('error', error))
        .finally(() => commit('setDistrictLoading', false))
    }
}
const mutations = {
    setProvinces: (state, Provinces) => state.provinces = Provinces,
    setProvinceLoading: (state, ProvinceLoading) => state.provinceLoading = ProvinceLoading,
    setProvinceIsSubmitting: (state, ProvinceIsSubmitting) => state.provinceIsSubmitting = ProvinceIsSubmitting,
    setCities: (state, Cities) => state.cities = Cities,
    setCityLoading: (state, CityLoading) => state.cityLoading = CityLoading,
    setCityIsSubmitting: (state, CityIsSubmitting) => state.cityIsSubmitting = CityIsSubmitting,
    setDistricts: (state, Districts) => state.districts = Districts,
    setDistrictLoading: (state, DistrictLoading) => state.districtLoading = DistrictLoading,
    setDistrictIsSubmitting: (state, DistrictIsSubmitting) => state.districtIsSubmitting = DistrictIsSubmitting,
}
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }