<script setup lang="ts">
import { computed } from "vue";
import { components } from "~/slices";

// Fetch the Home singleton
const prismic = usePrismic();
const { data: page } = await useAsyncData("home", () =>
  prismic.client.getSingle("home")
);

// Avoid rendering the Header slice here (it's already in the layout)
const filteredSlices = computed(
  () => page.value?.data?.slices?.filter((s) => s.slice_type !== "header") ?? []
);
</script>

<template>
  <SliceZone v-if="ImgContent" :slices="[ImgContent]" :components="components" />
  <SliceZone :slices="filteredSlices" :components="components" />
</template>