import axios from 'axios'
import { BASE_API_URL } from '../helpers/const'

const $host = axios.create({})

const $api = axios.create({
  withCredentials: true,
  baseURL: BASE_API_URL
})

$api.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${localStorage.getItem('access_token')}`
  return config
})

$api.interceptors.response.use(config => config, async error => {
  const originalRequest = error.config

  if(error.response.status === 401 && error.config && !error.config._isRetry){
    try {
      const response = await $host.post(`${BASE_API_URL}/auth/refresh`, null, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('access_token')}`
        }
    })
      localStorage.setItem('access_token', response.data.access_token)
      return $api.request(originalRequest)
    } catch (e) {
      throw e
    }
  }

  throw error
})

export {
  $api,
  $host
}
