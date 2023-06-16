import { $api } from '../http'

export default class EventService {
  static async fetchAll() {
    return await $api.get('/event')
  }

  static async create(params) {
    return await $api.post('/event', params)
  }

  static async destroy(id) {
    return await $api.delete(`/event/${id}`)
  }

  static async update(id, params) {
    return await $api.put(`/event/${id}`, params)
  }

  static async complete(id) {
    return await $api.put(`/event/${id}/complete`)
  }
}
