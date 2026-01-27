<script setup lang="ts">
import type { Content } from "@prismicio/client";

defineProps(getSliceComponentProps<Content.ImgContentSlice>());
</script>


<template>
  <section class="two-col"
  :class="{ reverse: slice.variation === 'imageLeft'}">
    <!-- Content -->
    <div class="text">
      <PrismicRichText :field="slice.primary.title" />
      <PrismicRichText :field="slice.primary.description" />
      <PrismicLink v-if="slice.primary.button_link" 
        :field="slice.primary.button_link" 
        class="btn-primary">
        {{ slice.primary.button_text || 'Learn More' }}
      </PrismicLink>
    </div>

    <!-- Image -->
    <div class="image">
      <PrismicImage :field="slice.primary.image" />
    </div>
  </section>
</template>



<style scoped>
.two-col {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.text, 
.image {
  flex: 1;
}

.reverse {
  flex-direction: row-reverse;
}

/* .image img {
  width: 100%;
  height: auto;
  display: block;
} */

.btn-primary {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 0.5rem;
  margin-top: 1rem;
}

.btn-primary:hover {
  background-color: #0056b3;
}

:deep(.text h1) {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

:deep(.text h2) {
  font-size: 2rem;
  margin-bottom: 1rem;
}

:deep(.text p) {
  line-height: 1.7;
  margin-bottom: 1rem;
}

:deep(.text strong) {
  font-weight: 700;
}

@media (max-width: 768px) {
  .two-col {
    flex-direction: column;
  }

  .reverse {
    flex-direction: column;
  }
}
</style>