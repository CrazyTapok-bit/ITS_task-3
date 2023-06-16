<template>
  <DialogDestroyItem
    :title="event.name"
    @confirm="destroy(event.id)"
  />
</template>

<script>
import { mapActions } from 'vuex'
import DialogDestroyItem from '../../components/Dialog/DialogDestroyItem.vue'

export default {
  name: 'EventDestroy',
  props: {
    event: { type: Object, required: true }
  },
  methods: {
    ...mapActions({
      destroy: 'event/destroy'
    })
  },
  components: {
    DialogDestroyItem
  }
}
</script>
