<template>
  <div class="bg-white shadow rounded-lg p-4">
    <h2 class="text-lg font-semibold mb-2">Notițele tale</h2>
    <ul class="space-y-1">
      <li v-for="nota in notite" :key="nota.id" class="text-sm text-gray-700">
        <div class="font-medium">{{ nota.titlu }}</div>
        <div class="text-gray-500 text-xs">{{ nota.continut?.slice(0, 80) }}...</div>
      </li>
    </ul>
    <Link href="/notite" class="block text-blue-600 mt-2 text-sm hover:underline">Vezi toate notițele</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
  notite: Array
})
</script>
/*
<template>
  <div class="bg-white shadow-md rounded-xl p-4 max-h-80 overflow-y-auto">
    <h2 class="text-lg font-semibold mb-3 text-gray-800">Notițele tale</h2>
    
    <div class="space-y-3">
      <div
        v-for="(nota, index) in notite"
        :key="nota.id"
        :class="cardColors[index % cardColors.length]"
        class="p-3 rounded-lg shadow-sm"
      >
        <h3 class="font-semibold text-sm mb-1">{{ nota.titlu }}</h3>
        <p class="text-xs text-gray-700">{{ nota.continut?.slice(0, 80) }}<span v-if="nota.continut?.length > 80">...</span></p>
      </div>
    </div>

    <Link
      href="/notite"
      class="mt-4 block text-center text-blue-600 text-sm font-medium hover:underline"
    >
      Vezi toate notițele
    </Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  notite: Array
})

const cardColors = [
  'bg-yellow-50 border-l-4 border-yellow-400',
  'bg-blue-50 border-l-4 border-blue-400',
  'bg-green-50 border-l-4 border-green-400',
  'bg-pink-50 border-l-4 border-pink-400',
  'bg-purple-50 border-l-4 border-purple-400'
]
</script>
