import EventService from '../services/EventService'

export default {
  namespaced: true,
  actions: {
    async create ({ commit }, params) {
      try{
        const { data } = await EventService.create(params)
        commit('events/ADD', data.data, { root: true })
      }catch(e){
        throw e
      }
    },
    async destroy ({ commit }, id) {
      try{
        await EventService.destroy(id)
        commit('events/DESTROY', id, { root: true })
      }catch(e){
        throw e
      }
    },
    async update ({ commit }, { id, ...params }) {
      try{
        const { data } = await EventService.update(id, params)
        commit('events/UPDATE', data.data, { root: true })
      }catch(e){
        throw e
      }
    },
    async complete ({ commit }, id) {
      try{
        const { data } = await EventService.complete(id)
        commit('events/UPDATE', data.data, { root: true })
      }catch(e){
        throw e
      }
    }
  }
}
