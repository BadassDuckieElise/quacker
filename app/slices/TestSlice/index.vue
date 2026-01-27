<script setup lang="ts">
import type { Content } from "@prismicio/client";

defineProps(getSliceComponentProps<Content.TestSliceSlice>());
</script>

<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Test Slice</h2>
    <p class="text-lg">{{ slice.primary.header }}</p>
        <img :src="slice.primary.image.url"></img>
    <!-- <pre class="bg-gray-100 p-4 rounded mt-4 overflow-x-auto">
      {{ slice }}
    </pre> -->
  </div>
</template>
