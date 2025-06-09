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

