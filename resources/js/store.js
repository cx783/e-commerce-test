import Vue from 'vue'
import Vuex from 'vuex'

import axios from 'axios'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    isAuthenticating: false,
    user: null,
  },
  getters: {
    isAuthenticated(state) {
      // TODO: hardcoded for developement
      return true
      // return state.user !== null
    }
  },
  mutations: {
    setAuthenticating(state, value) {
      state.isAuthenticating = value
    },
    setUser(state, user) {
      state.user = user
    }
  },
  actions: {
    async getUser({ commit }) {
      try {
        const { data } = await axios.get('/api/user');
        commit('setUser', data)
      } catch (err) {
        commit('setUser', null)
      }
    },
    async login({ commit, dispatch }, { email, password }) {
      commit('setAuthenticating', true)

      try {
        await axios.get('/sanctum/csrf-cookie')
        await axios.post('/login', {
          email,
          password
        })

        return dispatch('getUser')
      } catch (err) {
        console.log(err)
        throw err
      } finally {
        commit('setAuthenticating', false)
      }
    },
    async logout() {
      try {
        await axios.post('/logout')
        setUser(null)
      } catch (err) { }
    }
  }
})

export default store
