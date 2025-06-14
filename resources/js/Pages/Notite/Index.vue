<template>
  <div class="max-w-2xl mx-auto p-6">
    <Tabs />

    <h1 class="text-2xl font-bold mb-4">Notițele mele</h1>
    <form @submit.prevent="submitForm" class="space-y-4 mb-8">
      <div>
        <label class="block mb-1 font-medium">Titlu</label>
        <input v-model="form.titlu" type="text" class="w-full border rounded p-2" />
        <span v-if="errors.titlu" class="text-red-600 text-sm">{{ errors.titlu }}</span>
      </div>

      <div>
        <label class="block mb-1 font-medium">Conținut</label>
        <textarea v-model="form.continut" class="w-full border rounded p-2"></textarea>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Salvează notița
      </button>
    </form>

    <!-- Notificare succes -->
    <div v-if="$page.props.flash.success" class="mb-4 text-green-600 font-medium">
      {{ $page.props.flash.success }}
    </div>

    <!-- Listă notițe -->
    <div v-if="notite.length > 0" class="space-y-4">
      <div
        v-for="nota in notite"
        :key="nota.id"
        class="border rounded p-4 bg-gray-50 flex justify-between items-start"
      >
        <div>
          <h2 class="font-semibold">{{ nota.titlu }}</h2>
          <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ nota.continut }}</p>
        </div>
        <button
          @click="deleteNota(nota.id)"
          class="text-red-600 hover:text-red-800 text-sm"
        >
          Șterge
        </button>
      </div>
    </div>

    <div v-else class="text-gray-500">Nu ai adăugat nicio notiță momentan.</div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import Tabs from '@/Components/Tabs.vue'
import { defineProps } from 'vue'

defineProps({
  notite: Array
})

const form = useForm({
  titlu: '',
  continut: '',
})

const errors = ref({})

const submitForm = () => {
  form.post('/notite', {
    onError: (err) => {
      errors.value = err
    },
    onSuccess: () => {
      form.reset()
      errors.value = {}
    },
  })
}

const deleteNota = (id) => {
  if (confirm('Sigur vrei să ștergi această notiță?')) {
    router.delete(`/notite/${id}`)
  }
}
</script>
