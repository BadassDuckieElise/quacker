<script setup lang="ts">
import type { Content } from "@prismicio/client";

defineProps(getSliceComponentProps<Content.ImgContentSlice>());
</script>


<template>
  <section class="img-content py-5 w-full">
    <div 
      class="flex items-center w-full px-8 gap-8"
      :class="{ 'flex-row-reverse': slice.variation === 'imageLeft' }"
    > 
      <!-- Image -->
      <div class="flex-1 rounded-xl overflow-hidden shadow-lg h-80 min-w-0">
        <PrismicImage :field="slice.primary.image" class="w-full h-full object-cover" />
      </div>

      <!-- Content -->
      <div class="flex-1 flex flex-col gap-4 rounded border-2 border-solid border-emerald-200 p-6 shadow-lg min-w-0">
        <PrismicRichText :field="slice.primary.title" class="text-content" />
        <PrismicRichText :field="slice.primary.description" class="text-content" />
        
      </div>
    </div>
  </section>
</template>

<style scoped>
.text-content :deep(h1),
.text-content :deep(h2) {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: #1a202c;
}

.text-content :deep(h3) {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
  color: #2d3748;
}

.text-content :deep(p) {
  font-size: 1rem;
  line-height: 1.75;
  color: #4a5568;
  margin-bottom: 1rem;
}

.text-content :deep(ul),
.text-content :deep(ol) {
  margin-left: 1.5rem;
  margin-bottom: 1rem;
}

.text-content :deep(li) {
  margin-bottom: 0.5rem;
  line-height: 1.75;
}

.btn-primary {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  background-color: #10b981;
  color: white;
  font-weight: 600;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  text-decoration: none;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-primary:hover {
  background-color: #059669;
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}
</style>
