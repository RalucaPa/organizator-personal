<template>
  <div class="flex gap-6 border-b border-gray-200 mb-6">
    <Link
      href="/calendar"
      class="pb-2 text-gray-600 hover:text-blue-600 transition-all"
      :class="{
        'border-b-2 border-blue-500 text-blue-600 font-medium': $page.url === '/calendar'
      }"
    >
      Calendar
    </Link>
    <Link
      href="/evenimente"
      class="pb-2 text-gray-600 hover:text-blue-600 transition-all"
      :class="{
        'border-b-2 border-blue-500 text-blue-600 font-medium': $page.url === '/evenimente'
      }"
    >
      Evenimente
    </Link>
    <Link
      href="/notite"
      class="pb-2 text-gray-600 hover:text-blue-600 transition-all"
      :class="{
        'border-b-2 border-blue-500 text-blue-600 font-medium': $page.url === '/notite'
      }"
    >
      Notite
    </Link>
    <Link
      href="/recomandari"
      class="pb-2 text-gray-600 hover:text-blue-600 transition-all"
      :class="{
        'border-b-2 border-blue-500 text-blue-600 font-medium': $page.url === '/recomandari'
      }"
    >
      Oferte
    </Link>
    <Link
      href="/todo"
      class="pb-2 text-gray-600 hover:text-blue-600 transition-all"
      :class="{
        'border-b-2 border-blue-500 text-blue-600 font-medium': $page.url === '/todo'
      }"
    >
      Sarcini
    </Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
