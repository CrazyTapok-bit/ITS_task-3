import UserService from '../services/UserService'


export default {
  namespaced: true,
  actions: {
    async update ({ dispatch }, { id, ...params }) {
      try{
        const { data } = await UserService.update(id, params)
        dispatch('auth/updateUser', data.data, { root: true })
      }catch(e){
        throw e
      }
    },
    async subscribe ({ dispatch }, params) {
      const { data } = await UserService.subscribe(params)
      dispatch('auth/updateUser', data.data, { root: true })
    }
  }
}
