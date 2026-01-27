<script setup lang="ts">
import { components } from "~/slices";
import { SliceZone } from "@prismicio/vue";

// 1. Fetch a page from Prismic
const prismic = usePrismic();
const route = useRoute();
const { data: page } = await useAsyncData(route.params.uid as string, () =>
  prismic.client.getByUID("page", route.params.uid as string),
);
</script>

<template>
  <main>

    <!-- <pre>{{ page }}</pre> -->
    <!-- 2. Display the page's slices -->
    <SliceZone :slices="page?.data.slices ?? []" :components="components" />
  </main>
</template>