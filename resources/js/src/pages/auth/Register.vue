<template>
  <VCardText>
    <RegisterForm />
  </VCardText>
  <VCardText>
    <RouterLink
      :to="{ name: 'auth.login' }"
    >Увійти</RouterLink>
  </VCardText>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import SimpleLoader from '../../components/UI/Loader/SimpleLoader.vue'

export default {
  name: 'Register',
  components: {
    RegisterForm: defineAsyncComponent({
      loader: () => import('../../views/auth/RegisterForm.vue'),
      loadingComponent: SimpleLoader
    })
  }
}
</script>
