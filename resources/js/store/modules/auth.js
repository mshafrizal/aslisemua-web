const state = () => ({
  isLoggedIn: typeof localStorage.getItem('email') === 'string',
  user: null
})

const getters = {
  authUserInfo: (state, getters, rootState) => {
    return state.user
  },
  authLoggedIn: (state, getters, rootState) => {
    return state.isLoggedIn
  }
}

const mutations = {
  setAuth (state, user) {
    state.user = user
    Object.keys(user).forEach(key => {
      localStorage.setItem(key, user[key])
    })
  },
  removeAuth (state) {
    state.user = null
    localStorage.clear()
  }
}

const actions = {
  async authLogin ({commit, state}, payload) {
    return axios.post('/api/v1/sign-in/authenticate', payload).then(async (response) => {
      if (response.status === 200) {
        await commit('setAuth', response.data.data)
      }
      return response.data
    }).catch(error => {
      return error
    })
  },
  authLogout ({commit}) {
    commit('setIsLoggedIn', false)
    commit('removeAuth')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
