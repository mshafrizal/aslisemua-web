import axios from "axios"

const state = {
    search: '',
    start_price: '',
    end_price: '',
    category: '',
    brand: [],
    order_by: 'asc',
    color: '',
    gender: '',
    clothing_size: '',
    shoe_size: '',
    new_arrival: 'no',
    limit: 16,
    sale: 'no',
    results: null,
    loading: false,
}             
const getters = {
    getSearch: (state) => state.search,
    getStartPrice: (state) => state.start_price,
    getEndPrice: (state) => state.end_price,
    getCategory: (state) => state.category,
    getBrand: (state) => state.brand,
    getOrderBy: (state) => state.order_by,
    getColor: (state) => state.color,
    getGender: (state) => state.gender,
    getClothingSize: (state) => state.clothing_size,
    getShoeSize: (state) => state.shoe_size,
    getNewArrival: (state) => state.new_arrival,
    getLimit: (state) => state.limit,
    getSale: (state) => state.sale,
    getLoading: (state) => state.loading,
    getResults: (state) => state.results
}     
const actions = {
    updateSearch: ({ commit }, search) => commit('setSearch', search),
    updateStartPrice: ({ commit }, startPrice) => commit('setStartPrice', startPrice),
    updateEndPrice: ({ commit }, endPrice) => commit('setEndPrice', endPrice),
    updateCategory: ({ commit }, category) => commit('setCategory', category),
    updateBrand: ({ commit }, brand) => commit('setBrand', brand),
    updateOrderBy: ({ commit }, orderBy) => commit('setOrderBy', orderBy),
    updateColor: ({ commit }, color) => commit('setColor', color),
    updateGender: ({ commit }, gender) => commit('setGender', gender),
    updateClothingSize: ({ commit }, clothingSize) => commit('setClothingSize', clothingSize),
    updateShoeSize: ({ commit }, shoeSize) => commit('setShoeSize', shoeSize),
    updateNewArrival: ({ commit }, newArrival) => commit('setNewArrival', newArrival),
    updateLimit: ({ commit }, limit) => commit('setLimit', limit),
    updateSale: ({ commit }, sale) => commit('setSale', sale),
    async fetchProductsByFilter ({ commit, state }, payload) {
        console.log('called')
        commit('setResults', null)
        commit('setLoading', true)
        const params = {
            brand: state.brand.toString(),
            category: state.category ? state.category.name : '',
            start_price: state.start_price,
            end_price: state.end_price,
            order_by: state.order_by,
            new_arrival: state.new_arrival,
            sale: state.sale
        }
        await axios.get('/api/v1/products/public/main', {
            params: params
        })
        .then(response => commit('setResults', response.data))
        .catch(error => {
            console.log('error', error)
        }).finally(() => {
            commit('setLoading', false)
        })
    },
    clearFilter ({ commit }) {
        commit('setSearch', '')
        commit('setStartPrice', '')
        commit('setEndPrice', '')
        commit('setCategory', '')
        commit('setBrand', [])
        commit('setOrderBy', 'asc')
        commit('setColor', '')
        commit('setGender', '')
        commit('setClothingSize', '')
        commit('setNewArrival', 'no')
        commit('setLimit', 16)
        commit('setSale', 'no')
    }
}
const mutations = {
    setSearch: (state, search) => state.search = search,
    setStartPrice: (state, startPrice) => state.start_price = startPrice,
    setEndPrice: (state, endPrice) => state.end_price = endPrice,
    setCategory: (state, category) => state.category = category,
    setBrand: (state, brand) => state.brand = brand,
    setOrderBy: (state, orderBy) => state.order_by = orderBy,
    setColor: (state, color) => state.color = color,
    setGender: (state, gender) => state.gender = gender,
    setClothingSize: (state, clothingSize) => state.clothing_size = clothingSize,
    setNewArrival: (state, newArrival) => state.new_arrival = newArrival,
    setLimit: (state, limit) => state.limit = limit,
    setSale: (state, sale) => state.sale = sale,
    setLoading: (state, loading) => state.loading = loading,
    setResults: (state, results) => state.results = results,
}
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }