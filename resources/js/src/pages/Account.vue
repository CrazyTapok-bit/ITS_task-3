<template>
  <VCard>
    <VCardTitle>
      Кабінет
    </VCardTitle>
    <VCardText>
      <VRow>
        <VCol cols="6">
          <AccountUpdateForm />
        </VCol>
        <VCol cols="6">
          <p v-if="user.tg_token">Телеграм підключено, ваш айді <b>{{ user.tg_token }}</b></p>
          <Messendger v-else />
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>

<script>
import { mapGetters } from 'vuex';
import AccountUpdateForm from '../views/account/AccountUpdateForm.vue'
import Messendger from '../views/account/Messendger.vue'

export default {
  name: 'Account',
  data: () => ({
    loading: false
  }),
  computed: {
    ...mapGetters({
      user: 'auth/getUser'
    })
  },
  components: {
    AccountUpdateForm,
    Messendger
  }
}
</script>
