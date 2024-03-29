const state = () => ({
  isLoggedIn: false
})

const getters = {
  authUserInfo: (state, getters, rootState) => {
    if (localStorage.getItem('token') !== null) return localStorage.getItem('user')
    else return null
  },
  authLoggedIn: (state, getters, rootState) => {
    return state.isLoggedIn
  }
}

const mutations = {
  setAuth (state, user) {
    localStorage.setItem('token', user.token)
    localStorage.setItem('user', JSON.stringify(user))
  },
  setIsLoggedIn (state, payload) {
    state.isLoggedIn = localStorage.getItem('token') !== null
  },
  removeAuth (state) {
    state.isLoggedIn = false
    localStorage.clear()
  },
  initializeAuthStore (state) {
    if (localStorage.getItem('token')) {
      state.isLoggedIn = true
    }
  }
}

const actions = {
  async authLogin ({commit, state, dispatch}, payload) {
    return axios.post('/api/v1/sign-in/authenticate', payload).then(async (response) => {
      if (response.status === 200) {
        await commit('setAuth', response.data.data)
        await commit('setIsLoggedIn')
      }
      return Promise.resolve(response.data)
    }).catch(error => Promise.reject(error))
  },
  authLogout ({commit}) {
    commit('removeAuth')
    commit('setIsLoggedIn')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
