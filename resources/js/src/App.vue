<template>
  <VApp>
    <component :is="layoutResolve" />
  </VApp>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import SimpleLoader from './components/UI/Loader/SimpleLoader.vue'

export default {
  name: 'App',
  computed: {
    layoutResolve () {
      const { layout } = this.$route.meta
      return layout ? 'layout-' + layout : null
    }
  },
  components: {
    LayoutEmpty: defineAsyncComponent({
      loader: () => import('./layouts/LayoutEmpty.vue'),
      loadingComponent: SimpleLoader
    }),
    LayoutMain: defineAsyncComponent({
      loader: () => import('./layouts/LayoutMain.vue'),
      loadingComponent: SimpleLoader
    })
  }
}
</script>
