import ReminderService from '../services/ReminderService'

export default {
  namespaced: true,
  state: {
    items: []
  },
  getters: {
    getAll: state => state.items,
    isEmpty: (state, getters) => !getters.getAll.length,
    findById: (state, getters) => id => getters.getAll.find(item => item.id == id)
  },
  mutations: {
    SET: (state, items) => {
      state.items = items
    },
    ADD: (state, item) => {
      state.items.push(item)
    }
  },
  actions: {
    async fetchAll ({ commit, getters }) {
      try{
        if(!getters.isEmpty) return
        const { data } = await ReminderService.fetchAll()
        commit('SET', data.data)
      }catch(e){
        throw e
      }
    },
    reset ({ commit }) {
      commit('SET', [])
    }
  }
}
