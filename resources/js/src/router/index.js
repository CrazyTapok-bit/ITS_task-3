import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'
import store from '../store'

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior: () => ({
    top: 0,
    left: 0
  })
})

let _dirty = false

router.beforeEach(async (to, from, next) => {
  if(!store.getters['auth/isAuth'] && !_dirty) {
    try{
      await store.dispatch('auth/check')
    }catch(e){
      console.error(e)
      return next({ name: 'auth.login' })
    }finally{
      _dirty = true
    }
  }

  const isAuth = store.getters['auth/isAuth']
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)

  if (isAuth && to.name === 'auth.login') {
    next({ name: 'calendar' })
  } else if (requiresAuth && !isAuth) {
    next({ name: 'auth.login' })
  } else {
    next()
  }
})

export default router
