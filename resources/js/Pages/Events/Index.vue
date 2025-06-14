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

    <div v-else class="grid md:grid-cols-3 gap-6">
  <!-- Coloana 1-2: lista de evenimente -->
  <div class="md:col-span-2 space-y-4">
    <div
  v-for="event in filteredEvents.filter(e => e.image_url)"
  :key="event.id"
  class="border border-gray-300 rounded shadow-sm hover:shadow-md transition flex flex-col md:flex-row"
>
  <!-- Textul (în stânga) -->
  <div class="p-4 flex-1">
    <h2 class="text-xl font-semibold">{{ event.title }}</h2>
    <p class="text-gray-700">{{ event.description }}</p>
    <p class="text-sm text-gray-500 mt-1">
      📍 {{ event.location }} | 🕒 {{ formatDate(event.start_time) }}
    </p>

    <div v-if="adaugate.has(event.id)" class="mt-2 text-green-600 font-medium">
      ✅ Adăugat în calendar
    </div>
    <button
      v-else
      @click="adaugaInCalendar(event)"
      class="mt-2 bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded"
      :disabled="adaugate.has(event.id)"
    >
      Adaugă în calendar
    </button>
  </div>

  <!-- Imaginea (în dreapta) -->
  <img
    v-if="event.image_url"
    :src="event.image_url"
    alt="Imagine eveniment"
    class="md:w-52 w-full h-40 object-cover rounded-r"
  />
</div>

  </div>

  <!-- Coloana 3: notițe + oferte -->
  <div class="md:col-span-1 space-y-6">
    <!-- Widget notițe -->
    <NotiteWidget :notite="notite" />

    <!-- Oferte -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold text-gray-700 mb-2">Evenimente recomandate</h3>
      <div class="space-y-3">
        <OfferCard v-for="offer in offers" :key="offer.id" :offer="offer" />
      </div>
    </div>
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
import NotiteWidget from '@/Components/NotiteWidget.vue'
import OfferCard from '@/Components/OfferCard.vue'

const props = defineProps({
  events: Array,
  notite: Array,
  offers: Array,
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
  "Parcul Alexandru Ioan Cuza",
  "Parcul Cismigiu",
  "Club 99"
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
