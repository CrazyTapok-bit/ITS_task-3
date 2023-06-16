import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import * as components from 'vuetify/components'

import { createVuetify } from 'vuetify'

export default createVuetify({
  components,
  defaults: {
    VBtn: {
      color: 'primary'
    }
  }
})
