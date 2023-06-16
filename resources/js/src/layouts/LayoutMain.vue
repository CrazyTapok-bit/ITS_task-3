<template>
  <VLayout>
    <VAppBar>
      <template #prepend>
        Вітаю, {{ user?.username || 'Анонім' }}!
      </template>
      <template #append>
        <RouterLink
          :to="{ name: 'calendar' }"
          class="pr-4"
        >Календар</RouterLink>
        <RouterLink
          class="pr-4"
          :to="{ name: 'account' }"
        >Кабінет</RouterLink>
        <a href="#" @click.prevent="onLogout">Вихід</a>
      </template>
    </VAppBar>
    <VMain>
      <RouterView />
    </VMain>
  </VLayout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'LayoutMain',
  methods: {
    async onLogout () {
      try{
        await this.logout()
        this.$router.push({ name: 'auth.login' })
      }catch(e){
      }
    },
    ...mapActions({
      logout: 'auth/logout'
    })
  },
  computed: {
    ...mapGetters({
      user: 'auth/getUser'
    })
  }
}
</script>
