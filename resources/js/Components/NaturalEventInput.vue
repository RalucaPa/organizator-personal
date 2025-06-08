<template>
    <div class="my-6 p-4 bg-white rounded shadow space-y-4">
      <h2 class="text-lg font-semibold">Adauga un eveniment prin comanda text</h2>
      
      <textarea
        v-model="command"
        placeholder="Ex: Merg la teatru pe 15 mai la ora 19 la TNB"
        class="w-full p-2 border rounded resize-none"
        rows="3"
      ></textarea>
  
      <button
        @click="submitCommand"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        :disabled="loading"
      >
        {{ loading ? 'Se proceseaza...' : 'Adauga eveniment' }}
      </button>
  
      <p v-if="error" class="text-red-600">{{ error }}</p>
      <p v-if="success" class="text-green-600">{{ success }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  
  const command = ref('')
  const loading = ref(false)
  const error = ref('')
  const success = ref('')
  const emit = defineEmits(['event-added'])


  const submitCommand = async () => {
    error.value = ''
    success.value = ''
    loading.value = true
  
    try {
      const response = await axios.post('/ai/add-event', { command: command.value })
      success.value = 'Evenimentul a fost adaugat cu succes!'
      command.value = ''
      emit('event-added', response.data.event)
    } catch (err) {
      error.value = 'A aparut o eroare la procesarea comenzii.'
      console.error(err)
    } finally {
      loading.value = false
    }
  }
  </script>
  