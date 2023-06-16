<template>
  <VDialog
    v-model="dialog"
    activator="parent"
    width="500"
  >
    <VCard>
      <VToolbar
        color="primary"
      >
        <VListItem
          lines="two"
          title="Ви впевнені?"
          subtitle="Цю дію відмінити неможливо"
        />
      </VToolbar>
      <VDivider />
      <VCardTitle class="text-center">{{ title }}</VCardTitle>
      <slot></slot>
      <VCardText>
        <VRow>
          <VCol cols="12" class="d-flex gap-4">
            <VBtn
              color="error"
              :loading="loading"
              :disabled="loading"
              @click="confirm"
            >Так, видаляємо</VBtn>
            <VSpacer />
            <VBtn
              color="primary"
              :loading="loading"
              :disabled="loading"
              @click="toggleDialog"
            >Відмінити</VBtn>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<script>
export default {
  name: 'DialogDestroyItem',
  emits: ['confirm'],
  props: {
    title: { type: String, required: true }
  },
  data: () => ({
    dialog: false,
    loading: false
  }),
  methods: {
    toggleDialog () {
      this.dialog = !this.dialog
    },
    async confirm () {
      try{
        this.loading = true
        await this.$emit('confirm')
      }finally{
        this.loading = false
      }
    }
  }
}
</script>
