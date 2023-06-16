import { $api } from '../http'

export default class UserService {
  static async update(id, params) {
    return await $api.put(`/user/${id}`, params)
  }

  static async subscribe(params) {
    return await $api.post(`/user/subscribe`, params)
  }
}
