import { createApp } from 'vue'
import App from './App.vue'

/** Plugins */
import { loadFonts } from './plugins/webfontloader'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'

/** Initialization */
const app = createApp(App)

loadFonts()

app
  .use(vuetify)
  .use(router)
  .use(store)
  .mount('#app')
