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
    <VTextField
      v-model="form.repeat"
      label="Пароль"
      type="password"
      :loading="loading"
      placeholder="Повторіть пароль"
      :error-messages="getErrors(v$.form.repeat)"
    />
    <VBtn
      type="submit"
      :loading="loading"
      :disabled="loading"
      block
    >Зареєструватись</VBtn>
  </VForm>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { helpers, required, email, minLength, sameAs } from '@vuelidate/validators'
import { mapActions } from 'vuex'

export default {
  name: 'RegisterForm',
  setup: () => ({
    v$: useVuelidate({
      $autoDirty: true
    })
  }),
  data: () => ({
    loading: false,
    form: {
      email: null,
      password: null,
      repeat: null
    }
  }),
  validations () {
    return {
      form: {
        email: {
          required: helpers.withMessage('Вкажіть email', required),
          email: helpers.withMessage('Невірний формат email', email)
        },
        password: {
          required: helpers.withMessage('Вкажіть пароль', required),
          minLength: helpers.withMessage('Мінімільна довжина 8 символів', minLength(8))
        },
        repeat: {
          required: helpers.withMessage('Підтвердіть пароль', required),
          sameAs: helpers.withMessage('Паролі не співпадають', sameAs(this.form.password))
        }
      }
    }
  },
  methods: {
    async onSubmit () {
      this.v$.$touch()
      if (this.v$.$invalid) return

      this.loading = true

      try {
        await this.register({
          email: this.form.email,
          password: this.form.password
        })

        this.$router.push({ name: 'auth.login'})
      } finally {
        this.loading = false
      }
    },
    ...mapActions({
      register: 'auth/register'
    })
  },
  computed: {
    getErrors () {
      return v => v.$errors.map($error => $error.$message)
    }
  }
}
</script>
