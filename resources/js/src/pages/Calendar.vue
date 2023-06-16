<template>
  <FullscreenCalendar />
</template>

<script>
import { defineAsyncComponent } from 'vue'
import SimpleLoader from '../components/UI/Loader/SimpleLoader.vue'

export default {
  name: 'Calendar',
  components: {
    FullscreenCalendar: defineAsyncComponent({
      loader: () => import('../views/calendar/FullscreenCalendar.vue'),
      loadingComponent: SimpleLoader
    })
  }
}
</script>
