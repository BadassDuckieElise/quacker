<script setup lang="ts">
import type { Content } from "@prismicio/client";

defineProps(getSliceComponentProps<Content.HeaderSlice>());
</script>

<template>
  <section class="header flex items-center gap-4 w-full">
    <div class="title-wrapper flex-shrink-0">
      <PrismicRichText :field="slice.primary.Title" />
    </div>
    <div class="flex-1 flex justify-end">
      <div class="grid grid-cols-2 gap-4">
      <!-- <PrismicLink
        v-if="slice.primary.buttonpage1"
        :field="slice.primary.buttonpage1"
        class="headerbtn"
      >
        {{ slice.primary.buttontext1 || slice.primary.buttonpage1?.text }}
      </PrismicLink> -->
      <PrismicLink
        v-if="slice.primary.buttonpage2"
        :field="slice.primary.buttonpage2"
        class="headerbtn"
      >
        {{ slice.primary.buttontext2 || slice.primary.buttonpage2?.text }}
      </PrismicLink>
      <PrismicLink
        v-if="slice.primary.buttonpage3"
        :field="slice.primary.buttonpage3"
        class="headerbtn"
      >
        {{ slice.primary.buttontext3 || slice.primary.buttonpage3?.text }}
      </PrismicLink>
      </div>
    </div>
  </section>
</template>


<style scoped>
.title-wrapper :deep(h1),
.title-wrapper :deep(h2),
.title-wrapper :deep(h3),
.title-wrapper :deep(p) {
  font-size: 2rem;
  margin: 0;
}
</style>
