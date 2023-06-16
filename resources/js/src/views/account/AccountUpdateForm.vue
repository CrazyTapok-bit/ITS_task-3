<template>
  <VForm @submit.prevent="onSubmit">
    <VTextField
      v-model="form.username"
      label="Нове і'мя"
      placeholder="Введіть і'мя"
      :loading="loading"
    />
    <VTextField
      v-model="form.email"
      label="Нова пошта"
      placeholder="Введіть пошту"
      :loading="loading"
      :error-messages="getErrors(v$.form.email)"
    />
    <VTextField
      v-model="form.password"
      label="Новий пароль"
      placeholder="Повторіть пароль"
      :loading="loading"
      :error-messages="getErrors(v$.form.password)"
    />
    <VTextField
      v-model="form.repeat"
      label="Новий пароль ще раз"
      placeholder="Повторіть пароль"
      :loading="loading"
      :error-messages="getErrors(v$.form.repeat)"
    />
    <VBtn
      type="submit"
      :loading="loading"
      :disabled="loading"
      block
    >Оновити</VBtn>
  </VForm>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { helpers, required, email, minLength, sameAs, requiredIf } from '@vuelidate/validators'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'AccountUpdateForm',
  setup: () => ({
    v$: useVuelidate({
      $autoDirty: true
    })
  }),
  data: () => ({
    loading: false,
    form: {
      username: null,
      email: null,
      password: '',
      repeat: ''
    }
  }),
  validations () {
    return {
      form: {
        email: {
          email: helpers.withMessage('Невірний формат email', email)
        },
        password: {
          minLength: helpers.withMessage('Мінімільна довжина 8 символів', minLength(8))
        },
        repeat: {
          requiredIf: helpers.withMessage('Підтвердіть пароль', requiredIf(() => {
            return Boolean(this.form.password?.length)
          })),
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
        const form = Object.assign(
          { id: this.user?.id },
          this.form.username && { username: this.form.username },
          this.form.email && { email: this.form.email },
          this.form.password && { password: this.form.password }
        )
        await this.update(form)
      } finally {
        this.loading = false
      }
    },
    ...mapActions({
      update: 'user/update',
      check: 'auth/check'
    })
  },
  computed: {
    getErrors () {
      return v => v.$errors.map($error => $error.$message)
    },
    ...mapGetters({
      user: 'auth/getUser'
    })
  }
}
</script>
