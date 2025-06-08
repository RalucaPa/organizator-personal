<template>
  <div class="p-6">
    <Tabs />
    <h1 class="text-2xl font-bold mb-4">Evenimente in Bucuresti</h1>

    <!-- FILTRE -->
    <div class="mb-6 flex flex-wrap gap-4 items-center">
      <select v-model="filters.location" class="border px-3 py-2 rounded w-60">
        <option value="">Toate locatiile</option>
        <option v-for="loc in locations" :key="loc" :value="loc">
          {{ loc }}
        </option>
      </select>

      <input v-model="filters.date" type="date" class="border px-3 py-2 rounded" />

      <input
        v-model="filters.keyword"
        type="text"
        placeholder="Cauta in titlu"
        class="border px-3 py-2 rounded w-60"
      />

      <button
        @click="resetFilters"
        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-sm"
      >
        Reset
      </button>
    </div>

    <!-- LISTARE -->
    <div v-if="filteredEvents.length === 0" class="text-gray-600">
      Nu exista evenimente care se potrivesc.
    </div>

    <div v-else class="grid gap-4">
      <div
        v-for="event in filteredEvents"
        :key="event.id"
        class="border border-gray-300 rounded p-4 shadow-sm hover:shadow-md transition"
      >
        <h2 class="text-xl font-semibold">{{ event.title }}</h2>
        <p class="text-gray-700">{{ event.description }}</p>
        <p class="text-sm text-gray-500">
          📍 {{ event.location }} | 🕒 {{ formatDate(event.start_time) }}
        </p>

        <div v-if="adaugate.has(event.id)" class="mt-2 text-green-600 font-medium">
          ✅ Adaugat in calendar
        </div>
        <button
          v-else
          @click="adaugaInCalendar(event)"
          class="mt-2 bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded"
          :disabled="adaugate.has(event.id)"
        >
          Adauga in calendar
        </button>
      </div>
    </div>

    <!-- Toast vizual -->
    <div
      v-if="toast.message"
      :class="['fixed bottom-4 right-4 px-4 py-2 rounded shadow text-white', toast.success ? 'bg-green-600' : 'bg-red-600']"
    >
      {{ toast.message }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineProps } from 'vue'
import axios from 'axios'
import Tabs from '@/Components/Tabs.vue'

const props = defineProps({
  events: Array,
})

const locations = [
  "Teatrul National",
  "Cinema City AFI",
  "Arena Nationala",
  "Romexpo",
  "Parcul Herastrau",
  "Arenele Romane",
  "Teatrul Odeon",
  "Stadionul Steaua",
  "Gradina Botanica",
  "Opera Nationala",
]

const filters = ref({
  location: '',
  date: '',
  keyword: '',
})

const adaugate = ref(new Set())
const toast = ref({ message: '', success: true })

function showToast(message, success = true) {
  toast.value = { message, success }
  setTimeout(() => toast.value.message = '', 3000)
}

function resetFilters() {
  filters.value = {
    location: '',
    date: '',
    keyword: '',
  }
}

const filteredEvents = computed(() => {
  return props.events.filter((event) => {
    const matchLoc = filters.value.location
      ? event.location === filters.value.location
      : true

    const matchDate = filters.value.date
      ? event.start_time.startsWith(filters.value.date)
      : true

    const matchKeyword = filters.value.keyword
      ? event.title.toLowerCase().includes(filters.value.keyword.toLowerCase())
      : true

    return matchLoc && matchDate && matchKeyword
  })
})

function formatDate(dateStr) {
  const options = { dateStyle: 'full', timeStyle: 'short' }
  return new Date(dateStr).toLocaleString('ro-RO', options)
}

function adaugaInCalendar(event) {
  if (adaugate.value.has(event.id)) return

  axios.post('/calendar/events', {
    event_id: event.id
  })
  .then(() => {
    adaugate.value.add(event.id)
    showToast('Evenimentul a fost adaugat in calendar ✅', true)
  })
  .catch(() => {
    showToast('Eroare la adaugarea in calendar ❌', false)
  })
}
</script>
