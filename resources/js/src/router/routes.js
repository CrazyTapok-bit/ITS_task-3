export default [
  {
    path: '/',
    name: 'home',
    redirect: {
      name: 'auth.login'
    }
  },
  {
    path: '/auth',
    component: () => import('../pages/Auth.vue'),
    meta: {
      layout: 'empty'
    },
    children: [
      {
        path: '',
        name: 'auth.login',
        component: () => import('../pages/auth/Login.vue')
      },
      {
        path: 'register',
        name: 'auth.register',
        component: () => import('../pages/auth/Register.vue')
      }
    ]
  },
  {
    path: '/calendar',
    name: 'calendar',
    component: () => import('../pages/Calendar.vue'),
    meta: {
      layout: 'main',
      requiresAuth: true
    }
  },
  {
    path: '/account',
    name: 'account',
    component: () => import('../pages/Account.vue'),
    meta: {
      layout: 'main',
      requiresAuth: true
    }
  }
]
