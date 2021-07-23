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
      return response.data
    }).catch(error => {
      let message = ''
      if (error.response) {
        message = error.response.data.message
      } else if (error.request) {
        dispatch('showSnackbar', {
          value: true,
          message: 'Something went wrong, please contact admin for any help',
          type: 'error'
        }, { root: true })
      } else {
        message = error.message
      }
      dispatch('showSnackbar', {
        value: true,
        message: message,
        type: 'error'
      }, { root: true })
    })
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
