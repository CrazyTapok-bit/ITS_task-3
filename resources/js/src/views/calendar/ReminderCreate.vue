<template>
  <VDialog
    v-model="dialog"
    activator="parent"
    width="500"
  >
    <VCard>
      <VToolbar
        color="primary"
        title="Нагадування"
      />
      <VCardText>
        <VForm @submit.prevent="onSubmit">
          <VTextField
            v-model="form.name"
            label="Назва"
            placeholder="Назва"
            :loading="loading"
            :error-messages="getErrors(v$.form.name)"
          />
          <VColorPicker
            v-model="form.color"
            label="Колір"
            placeholder="Колір"
            :loading="loading"
            :error-messages="getErrors(v$.form.color)"
            mode="hex"
          />
          <DatePicker
            v-model="form.date"
            placeholder="Дата та час"
            locale="uk"
            :min-date="new Date()"
            :disabled="loading"
          />
          <VMessages
            :active="!!getErrors(v$.form.date).length"
            color="error"
            :messages="getErrors(v$.form.date)?.[0]"
            :style="{ opacity: 1 }"
          />
          <VSelect
            v-model="form.repeat"
            placeholder="Частота повторення"
            label="Частота повторення"
            :items="REMINDER_TYPES"
            :loading="loading"
          />
          <VSelect
            v-if="isTypeWeekly"
            v-model="form.days"
            placeholder="Оберіть дні"
            label="Оберіть дні"
            :items="REMINDER_DAYS"
            :error-messages="getErrors(v$.form.days)"
            :loading="loading"
            multiple
          />
          <VBtn
            type="submit"
            :loading="loading"
            :disabled="loading"
            block
          >Створити</VBtn>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { helpers, required, requiredIf } from '@vuelidate/validators'
import DatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { REMINDER_TYPES, REMINDER_WEEKLY, REMINDER_DAYS } from '../../helpers/const'
import { mapActions } from 'vuex'
import { timeZone } from '../../helpers/func'

export default {
  name: 'ReminderCreate',
  setup: () => ({
    v$: useVuelidate({
      $autoDirty: true
    }),
    REMINDER_TYPES,
    REMINDER_WEEKLY,
    REMINDER_DAYS
  }),
  data: () => ({
    dialog: false,
    loading: false,
    form: {
      name: null,
      color: '#6200ee',
      date: null,
      repeat: null,
      days: []
    }
  }),
  validations () {
    return {
      form: {
        name: {
          required: helpers.withMessage('Введіть назву', required)
        },
        color: {
          required: helpers.withMessage('Оберіть колір', required)
        },
        date: {
          required: helpers.withMessage('Оберіть дату та час', required)
        },
        days: {
          requiredIf: helpers.withMessage('Оберіть дні', requiredIf(this.isTypeWeekly))
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
        await this.create({
          ...this.form,
          date: timeZone(new Date(this.form.date))
        })
        this.form.name = null
        this.form.date = null
        this.form.repeat = null
        this.form.days = []
        this.v$.$reset()
        this.dialog = false
      } catch(e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    ...mapActions({
      create: 'reminder/create'
    })
  },
  computed: {
    getErrors () {
      return v => v.$errors.map($error => $error.$message)
    },
    isTypeWeekly () {
      return this.form.repeat === this.REMINDER_WEEKLY
    }
  },
  components: {
    DatePicker
  }
}
</script>
