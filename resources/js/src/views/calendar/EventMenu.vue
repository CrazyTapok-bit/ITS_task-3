<template>
  <VMenu activator="parent" >
    <VList>
      <VListItem link v-if="!isCompleted" @click="onClick">
        <VListItemTitle>Виконано</VListItemTitle>
      </VListItem>
      <VListItem link v-if="!isCompleted">
        <VListItemTitle>Редагувати</VListItemTitle>
        <EventUpdate :event="event" />
      </VListItem>
      <VListItem link>
        <VListItemTitle>Видалити</VListItemTitle>
        <EventDestroy :event="event" />
      </VListItem>
    </VList>
  </VMenu>
</template>

<script>
import { mapActions } from 'vuex'
import { EVENT_STATUS_COMPLETED } from '../../helpers/const'
import EventDestroy from './EventDestroy.vue'
import EventUpdate from './EventUpdate.vue'

export default {
  name: 'EventMenu',
  props: {
    event: { type: Object, require: true }
  },
  data: () => ({
    loading: false
  }),
  methods: {
    async onClick () {
      if(this.loading) return
      try{
        await this.complete(this.event.id)
      }finally{
        this.loading = false
      }
    },
    ...mapActions({
      complete: 'event/complete'
    })
  },
  computed: {
    isCompleted () {
      return this.event.status === EVENT_STATUS_COMPLETED
    }
  },
  components: {
    EventDestroy,
    EventUpdate
  }
}
</script>
