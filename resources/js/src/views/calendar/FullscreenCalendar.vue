<template>
  <VCard :loading="loading" class="mt-4">
    <VCardText>
      <VBtn class="mr-2">
        Створити нагадування
        <ReminderCreate />
      </VBtn>
      <VBtn>
        Створити подію
        <EventCreate />
      </VBtn>
    </VCardText>
    <VCardText>
      <FullCalendar
        class="calendar"
        :options="calendarOptions"
        :events="getEvents"
        ref="calendar"
      >
        <template #eventContent="arg">
          <div class="d-flex align-center">
            <b>{{ arg.timeText }}</b>
            <i>{{ arg.event.title }}</i>
            <VSpacer />
            <EventMenu
              v-if="arg.event.extendedProps.type === 'event'"
              :event="findEventById(arg.event.id)"
            />
          </div>
        </template>
      </FullCalendar>
    </VCardText>
  </VCard>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import timelinePlugin from '@fullcalendar/timeline'
import ReminderCreate from './ReminderCreate.vue'
import EventCreate from './EventCreate.vue'
import { mapActions, mapGetters } from 'vuex'
import EventMenu from './EventMenu.vue'

export default {
  name: 'FullscreenCalendar',
  data () {
    return {
      loading: false,
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          timelinePlugin,
          interactionPlugin
        ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timelineYear'
        },
        initialView: 'dayGridMonth',
        contentHeight: 500,
        events: [],
        eventDidMount: arg => {
          if (arg.event.extendedProps.type !== 'reminder') return
          const dot = document.createElement('div')
          dot.classList.add('dot')
          dot.style.backgroundColor = arg.event.extendedProps.eventColor
          arg.el.appendChild(dot)
        },
        views: {
          year: {
            type: 'timeline',
            buttonText: 'Year',
            dateIncrement: { years: 1 },
            slotDuration: { months: 1 },
            visibleRange: date => ({
              start: date.clone().startOf('year'),
              end: date.clone().endOf("year")
            })
          }
        }
      }
    }
  },
  async mounted () {
    this.loading = true
    await Promise.all([
      this.fetchEvents(),
      this.fetchReminders()
    ])
    this.loading = false
  },
  methods: {
    transformEvents () {
      const events = this.getEvents.map(event => ({
        start: event.from,
        end: event.to,
        title: event.name,
        type: 'event',
        ...event
      }))
      const reminders = this.getReminders.map(reminder => ({
        title: reminder.name,
        type: 'reminder',
        start: reminder.date,
        eventColor: reminder.color
      }))
      this.$refs.calendar.getApi().removeAllEvents()
      this.$refs.calendar.getApi().addEventSource(events)
      this.$refs.calendar.getApi().addEventSource(reminders)
    },
    ...mapActions({
      fetchEvents: 'events/fetchAll',
      fetchReminders: 'reminders/fetchAll'
    })
  },
  computed: {
    ...mapGetters({
      getEvents: 'events/getAll',
      getReminders: 'reminders/getAll',
      findEventById: 'events/findById'
    })
  },
  watch: {
    getEvents: {
      handler () {
        this.transformEvents()
      },
      deep: true
    },
    getReminders: {
      handler () {
        this.transformEvents()
      },
      deep: true
    }
  },
  components: {
    FullCalendar,
    ReminderCreate,
    EventCreate,
    EventMenu
  }
}
</script>

<style lang='css'>
.fc-icon-chevron-right::before,
.fc-icon-chevron-left::before{
  transform: translate(-50%, -50%);
  position: absolute;
  top: 50%;
  left: 50%;
}
.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  position: absolute;
  left: 5px;
  top: 50%;
  transform: translateY(-50%);
}
.dot + div,
.dot ~ div {
  margin-left: 20px;
}
</style>
