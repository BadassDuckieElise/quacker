<script setup lang="ts">
import type { Content } from "@prismicio/client";
import { computed } from 'vue';

const props = defineProps(getSliceComponentProps<Content.FooterSlice>());

const limitLines = (field: any) => {
  if (!field) return field;
  
  return field.map((block: any) => {
    if (block.text && block.text.includes('\n')) {
      const lines = block.text.split('\n');
      return {
        ...block,
        text: lines.slice(0, 4).join('\n')
      };
    }
    return block;
  });
};

const limitedDescription = computed(() => limitLines(props.slice.primary.footerdescription));
const limitedDescription2 = computed(() => limitLines(props.slice.primary.footerdescription2));
</script>

<template>
  <!-- Default Variation -->
  <section v-if="slice.variation === 'default'" class="footer flex flex-col items-center gap-4 w-full">
    <div class="title-wrapper shrink-0 w-full pb-4">
      <PrismicRichText
        v-if="Array.isArray(slice.primary.footerheader)"
        :field="slice.primary.footerheader"
      />
      <span v-else>{{ slice.primary.footerheader }}</span>
    </div>  
    <div class="flex w-full items-start gap-8">
      <div class="title-wrapper shrink-0 flex-1">
        <PrismicRichText :field="limitedDescription" />
      </div>
      <div class="title-wrapper shrink-0 flex-1">
        <PrismicRichText :field="limitedDescription2" />
      </div>
    </div>
  </section>

  <!-- Footer with Image -->
  <section v-else-if="slice.variation === 'footerimage'" class="footer flex items-center gap-8 w-full px-8">
    <div class="flex-1">
      <h3 class="footer-title mb-4">{{ slice.primary.footerheader }}</h3>
      <PrismicRichText :field="limitedDescription" class="footer-content" />
    </div>
    <div class="flex-1 rounded-lg overflow-hidden shadow-lg">
      <PrismicImage :field="slice.primary.footerimage" class="w-full h-64 object-cover" />
    </div>
  </section>

  <!-- Footer with Map -->
  <section v-else-if="slice.variation === 'footermap'" class="footer flex items-center gap-8 w-full px-8">
    <div class="flex-1">
      <h3 class="footer-title mb-4">{{ slice.primary.footerheader }}</h3>
      <PrismicRichText :field="limitedDescription" class="footer-content" />
    </div>
    <div class="flex-1 rounded-lg overflow-hidden shadow-lg bg-gray-200 h-64 flex items-center justify-center">
      <div v-if="slice.primary.footermap" class="text-center">
        <p class="text-sm text-gray-600">
          📍 Lat: {{ slice.primary.footermap.latitude }}<br>
          Lng: {{ slice.primary.footermap.longitude }}
        </p>
      </div>
    </div>
  </section>
</template>


<style scoped>
.title-wrapper :deep(h1),
.title-wrapper :deep(h2),
.title-wrapper :deep(h3) {
  font-size: 1.25rem;
  font-weight: 600;
  margin: 0;
}

.title-wrapper :deep(p),
.title-wrapper :deep(li) {
  font-size: 0.875rem;
  margin: 0;
  line-height: 1.5;
}

.footer-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a202c;
  margin: 0;
}

.footer-content :deep(p),
.footer-content :deep(li) {
  font-size: 0.875rem;
  line-height: 1.5;
  margin-bottom: 0.5rem;
}

.footer-content :deep(h3) {
  font-size: 1.125rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
}
</style>