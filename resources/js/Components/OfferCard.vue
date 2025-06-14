<template>
  <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">
    <img :src="offer.image_url" alt="" class="w-full h-48 object-cover rounded mb-2" />
    <h2 class="text-lg font-semibold">{{ offer.title }}</h2>
    <p class="text-sm text-gray-600 mb-1">{{ offer.description }}</p>
    <p v-if="offer.price" class="text-md text-green-700 font-bold">
      {{ Number(offer.price).toFixed(2) }} RON
    </p>
    <a :href="offer.link" target="_blank" class="text-blue-500 mt-2 inline-block hover:underline">Vezi eveniment</a>
  </div>
</template>

<script setup>
defineProps({
  offer: Object
})
</script>
