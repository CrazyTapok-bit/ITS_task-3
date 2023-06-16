import AuthService from '../services/AuthService'
import jwt_decode from 'jwt-decode'

export default {
  namespaced: true,
  state: {
    user: {},
    isAuth: false,
  },
  getters: {
    isAuth: state => state.isAuth,
    getUser: state => state.user
  },
  mutations: {
    SET_IS_AUTH: (state, bool) => {
      state.isAuth = bool
    },
    SET_USER: (state, user) => {
      state.user = user
    }
  },
  actions: {
    async login ({ commit }, params) {
      try{
        const { data } = await AuthService.login(params)
        localStorage.setItem('access_token', data.access_token)

        const { user } = jwt_decode(data.access_token)

        commit('SET_IS_AUTH', true)
        commit('SET_USER', user)
      }catch(e){
        throw e
      }
    },
    async register ({ }, params) {
      try{
        await AuthService.register(params)
      }catch(e){
        throw e
      }
    },
    async check ({ commit }) {
      try{
        if (!localStorage.getItem('access_token')) return

        const { data } = await AuthService.check()
        localStorage.setItem('access_token', data.access_token)

        const { user } = jwt_decode(data.access_token)

        commit('SET_IS_AUTH', true)
        commit('SET_USER', user)
      }catch(e){
        throw e
      }
    },
    async logout ({ dispatch }) {
      try{
        await AuthService.logout()
        dispatch('reset', null, { root: true })
        localStorage.removeItem('access_token')
      }catch(e){
        throw e
      }
    },
    reset ({ commit }) {
      commit('SET_IS_AUTH', false)
      commit('SET_USER', {})
    },
    updateUser ({ commit }, user) {
      commit('SET_USER', user)
    }
  }
}
