<template>
  <h3>Щоб підключити месенджер, авторизуйтесь</h3>
  <SimpleLoader v-if="loading" />
  <div v-else ref="telegram"></div>
</template>

<script>
import { mapActions } from 'vuex'
import SimpleLoader from '../../components/UI/Loader/SimpleLoader.vue'
const TELEGRAM_BOT_NAME = import.meta.env.VITE_TELEGRAM_BOT_NAME

export default {
  name: 'Messendger',
  data: () => ({
    loading: false
  }),
  methods: {
    async onTelegramAuth (user) {
      try{
        this.loading = true
        await this.subscribe(user)
      }finally{
        this.loading = false
      }
    },
    ...mapActions({
      subscribe: 'user/subscribe'
    })
  },
  mounted () {
    const script = document.createElement('script')
    script.async = true
    script.src = 'https://telegram.org/js/telegram-widget.js?21'
    script.setAttribute('data-size', 'large')
    script.setAttribute('data-telegram-login', TELEGRAM_BOT_NAME)
    script.setAttribute('data-request-access', 'write')
    window.onTelegramAuth = this.onTelegramAuth
    script.setAttribute('data-onauth', 'onTelegramAuth(user)')
    this.$refs.telegram.appendChild(script)
  },
  components: {
    SimpleLoader
  }
}
</script>
