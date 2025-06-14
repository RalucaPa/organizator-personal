<template>
  <tabs />
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Recomandări pentru tine</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <OfferCard v-for="offer in offers" :key="offer.id" :offer="offer" />
    </div>
  </div>
</template>

<script setup>
import Tabs from '@/Components/Tabs.vue'
import OfferCard from '@/Components/OfferCard.vue'
import { defineProps } from 'vue'

defineProps({ offers: Array })
</script>
