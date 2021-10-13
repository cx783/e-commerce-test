import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import axios from 'axios'

import cart from './modules/cart'

Vue.use(Vuex)

// Save the state in local storage for persist between page reloads
const  dataState = createPersistedState({
  key: 'ec-cart',
  paths: ['cart.items']
})

const store = new Vuex.Store({
  modules: {
    cart
  },
  plugins: [dataState],
  state: {
    verifiedAuthentication: false,
    isAuthenticating: false,
    isLogout: false,
    user: null,
    errorMessages: []
  },
  getters: {
    isAuthenticated(state) {
      return state.user !== null
    }
  },
  mutations: {
    setVerifiedAuthentication(state, value) {
      state.verifiedAuthentication = value
    },
    setAuthenticating(state, value) {
      state.isAuthenticating = value
    },
    setIsLogout(state, value) {
      state.isLogout = value
    },
    setUser(state, user) {
      state.user = user
    },
    setErrorMessages(state, messages) {
      state.errorMessages = messages
    }
  },
  actions: {
    async verifyAuthentication({ commit, dispatch }) {
      await dispatch('getUser')
      commit('setVerifiedAuthentication', true)
    },
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
        commit('setVerifiedAuthentication', true)
        commit('setAuthenticating', false)
      }
    },
    async logout({ commit }) {
      try {
        commit('setIsLogout', true)
        await axios.post('/logout')
        setUser(null)
      } catch (err) { }
      finally {
        commit('setIsLogout', false)
        commit('setVerifiedAuthentication', false)
      }
    }
  }
})

export default store
