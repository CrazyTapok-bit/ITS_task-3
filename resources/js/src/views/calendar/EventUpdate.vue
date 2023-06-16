<template>
  <VDialog
    v-model="dialog"
    activator="parent"
    width="500"
  >
    <VCard>
      <VToolbar
        color="primary"
        title="Подія"
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
            range
            :min-date="new Date()"
            multi-calendars
            multi-calendars-solo
            :disabled="loading"
          />
          <VMessages
            :active="!!getErrors(v$.form.date).length"
            color="error"
            :messages="getErrors(v$.form.date)?.[0]"
            :style="{ opacity: 1 }"
          />
          <VBtn
            type="submit"
            :loading="loading"
            :disabled="loading"
            block
          >Оновити</VBtn>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { helpers, required } from '@vuelidate/validators'
import DatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { mapActions } from 'vuex'
import { timeZone } from '../../helpers/func'

export default {
  name: 'EventUpdate',
  props: {
    event: { type: Object, require: true }
  },
  setup: () => ({
    v$: useVuelidate({
      $autoDirty: true
    })
  }),
  data () {
    return {
      dialog: false,
      loading: false,
      form: {
        name: this.event.name,
        color: this.event.color,
        date: [this.event.from, this.event.to]
      }
    }
  },
  validations: () => ({
    form: {
      name: {
        required: helpers.withMessage('Введіть назву', required)
      },
      color: {
        required: helpers.withMessage('Оберіть колір', required)
      },
      date: {
        required: helpers.withMessage('Оберіть дату та час', required)
      }
    }
  }),
  methods: {
    async onSubmit () {
      this.v$.$touch()
      if (this.v$.$invalid) return

      this.loading = true

      try{
        await this.update({
          id: this.event.id,
          name: this.form.name,
          color: this.form.color,
          from: timeZone(new Date(this.form.date?.[0])),
          to: timeZone(new Date(this.form.date?.[1]))
        })
        this.v$.$reset()
        this.dialog = false
      }finally{
        this.loading = false
      }
    },
    ...mapActions({
      update: 'event/update'
    })
  },
  computed: {
    getErrors () {
      return v => v.$errors.map($error => $error.$message)
    }
  },
  components: {
    DatePicker
  }
}
</script>
