<template>
  <VForm @submit.prevent="onSubmit">
    <VTextField
      v-model="form.email"
      label="Пошта"
      :loading="loading"
      placeholder="Введіть пошту"
      :error-messages="getErrors(v$.form.email)"
    />
    <VTextField
      v-model="form.password"
      label="Пароль"
      type="password"
      :loading="loading"
      placeholder="Введіть пароль"
      :error-messages="getErrors(v$.form.password)"
    />
    <VBtn
      type="submit"
      :loading="loading"
      :disabled="loading"
      block
    >Увійти</VBtn>
  </VForm>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { helpers, required, email } from '@vuelidate/validators'
import { mapActions } from 'vuex'

export default {
  name: 'LoginForm',
  setup: () => ({
    v$: useVuelidate({
      $autoDirty: true
    })
  }),
  data: () => ({
    loading: false,
    form: {
      email: null,
      password: null
    }
  }),
  validations: () => ({
    form: {
      email: {
        required: helpers.withMessage('Вкажіть email', required),
        email: helpers.withMessage('Невірний формат email', email)
      },
      password: {
        required: helpers.withMessage('Вкажіть пароль', required)
      }
    }
  }),
  methods: {
    async onSubmit () {
      this.v$.$touch()
      if (this.v$.$invalid) return

      this.loading = true

      try {
        await this.login({
          email: this.form.email,
          password: this.form.password
        })

        this.$router.push({ name: 'calendar'})
      } finally {
        this.loading = false
      }
    },
    ...mapActions({
      login: 'auth/login'
    })
  },
  computed: {
    getErrors () {
      return v => v.$errors.map($error => $error.$message)
    }
  }
}
</script>
