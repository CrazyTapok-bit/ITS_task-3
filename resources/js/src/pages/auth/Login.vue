<template>
  <VCardText>
    <LoginForm />
  </VCardText>
  <VCardText>
    <RouterLink
      :to="{ name: 'auth.register' }"
    >Зареєструватись</RouterLink>
  </VCardText>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import SimpleLoader from '../../components/UI/Loader/SimpleLoader.vue'

export default {
  name: 'Login',
  components: {
    LoginForm: defineAsyncComponent({
      loader: () => import('../../views/auth/LoginForm.vue'),
      loadingComponent: SimpleLoader
    })
  }
}
</script>
