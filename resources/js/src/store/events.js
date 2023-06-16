import EventService from '../services/EventService'

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
    },
    DESTROY: (state, id) => {
      state.items = state.items.filter(item => item.id != id)
    },
    UPDATE: (state, item) => {
      const idx = state.items.findIndex(_ => _.id == item.id)
      if(idx < 0) return
      state.items[idx] = item
    }
  },
  actions: {
    async fetchAll ({ commit, getters }) {
      try{
        if(!getters.isEmpty) return
        const { data } = await EventService.fetchAll()
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
