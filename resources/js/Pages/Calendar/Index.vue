<template>
  <div class="p-6">
    <Tabs />
    <h1 class="text-2xl font-bold mb-4">Calendarul meu</h1>
    <NaturalEventInput @event-added="addEventToCalendar" />
    <FullCalendar :options="calendarOptions" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import axios from 'axios'
import tippy from 'tippy.js'
import 'tippy.js/dist/tippy.css'
import NaturalEventInput from '@/Components/NaturalEventInput.vue'
import Tabs from '@/Components/Tabs.vue'

const events = ref([])

const calendarOptions = ref({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  events: events.value,
  timezone: 'local', 
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  eventContent: function(arg) {
    const event = arg.event
    const location = event.extendedProps.location || ''
    const startTime = new Date(event.start).toLocaleTimeString('ro-RO', {
      hour: '2-digit',
      minute: '2-digit'
    })

    const container = document.createElement('div')
    container.innerHTML = `<b>${event.title}</b><br><small>${startTime} - ${location}</small>`

    return { domNodes: [container] }
  },
  eventDidMount: function (info) {
    if (info.event.extendedProps.description) {
      setTimeout(() => {
        tippy(info.el, {
          content: info.event.extendedProps.description,
          placement: 'top',
        })
      }, 0)
    }
  }
})

onMounted(() => {
  axios.get('/calendar/events').then(res => {
    events.value = res.data
    calendarOptions.value.events = res.data
  })
})

function addEventToCalendar(event) {
  events.value.push(event)
  calendarOptions.value = {
      ...calendarOptions.value,
      events: [...events.value]
    }
}
</script>

<style scoped>
.fc .fc-toolbar-title {
  font-size: 1.25rem;
  font-weight: 600;
}
</style>
