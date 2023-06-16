import { $api } from '../http'

export default class ReminderService {
  static async fetchAll() {
    return await $api.get('/reminder')
  }

  static async create(params) {
    return await $api.post('/reminder', params)
  }
}
