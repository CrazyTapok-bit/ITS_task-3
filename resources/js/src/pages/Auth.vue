<template>
  <div class="d-flex align-center justify-center pa-4 h-100">
    <VCard max-width="450" width="100%" >
      <VCardText class="pt-2">
        <h5 class="text-h5">Ласкаво просимо!</h5>
      </VCardText>
      <RouterView />
    </VCard>
  </div>
</template>

<script>
export default {
    name: "Auth"
}
</script>
