import ReminderService from '../services/ReminderService'

export default {
  namespaced: true,
  actions: {
    async create({ commit }, params) {
      try{
        const { data } = await ReminderService.create(params)
        commit('reminders/ADD', data.data, { root: true })
      }catch(e){
        throw e
      }
    }
  }
}
