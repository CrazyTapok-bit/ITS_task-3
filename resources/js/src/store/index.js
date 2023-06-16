import { createStore } from 'vuex'
import auth from './auth'
import user from './user'
import event from './event'
import events from './events'
import reminder from './reminder'
import reminders from './reminders'

export default createStore({
  namespaced: true,
  actions: {
    reset ({ dispatch }) {
      dispatch('auth/reset', null, { root: true })
      dispatch('events/reset', null, { root: true })
      dispatch('reminders/reset', null, { root: true })
    }
  },
  modules: {
    auth,
    user,
    event,
    events,
    reminder,
    reminders
  }
})
