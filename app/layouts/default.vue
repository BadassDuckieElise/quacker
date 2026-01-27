<template>
<main class="min-h-screen flex flex-col">
<header class="bg-emerald-600 h-20 p-4 flex items-center">
  <SliceZone v-if="headerSlice" :slices="[headerSlice]" :components="components" />
</header>
<article class="m-4 p-4 flex-1">
<!-- In dit slot element worden de pages geladen -->
<slot />
</article>
<footer class="bg-emerald-600 py-6 px-4 flex items-center justify-center">
  <SliceZone v-if="footerSlice" :slices="[footerSlice]" :components="components" />
</footer>
</main>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { usePrismic } from '#imports'
import { SliceZone } from '@prismicio/vue'
import { components } from '~/slices'

const { client } = usePrismic()

const { data: settings } = await useAsyncData('settings', () =>
  client.getSingle('settings').catch(() => null)
)

const { data: home } = await useAsyncData('home-header', () =>
  client.getSingle('home').catch(() => null)
)

const headerSlice = computed(() => {
  const fromSettings = settings.value?.data?.slices?.find(
    (slice) => slice.slice_type === 'header'
  )
  if (fromSettings) return fromSettings
  return home.value?.data?.slices?.find((slice) => slice.slice_type === 'header')
})

const footerSlice = computed(() => {
  const fromSettings = settings.value?.data?.slices?.find(
    (slice) => slice.slice_type === 'footer'
  )
  if (fromSettings) return fromSettings
  return home.value?.data?.slices?.find((slice) => slice.slice_type === 'footer')
})
</script>

