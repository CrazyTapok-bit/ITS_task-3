import { BASE_API_URL } from '../helpers/const'
import { $api, $host } from '../http'

export default class AuthService {
  static async login(params) {
    return await $api.post('/auth/login', params)
  }

  static async register(params) {
    return await $api.post('/auth/register', params)
  }

  static async logout() {
    return await $api.post('/auth/logout')
  }

  static async check() {
    return await $host.post(BASE_API_URL + '/auth/refresh', {}, {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('access_token')
      }
    })
  }
}
