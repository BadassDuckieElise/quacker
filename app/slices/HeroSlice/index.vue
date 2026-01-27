<script setup lang="ts">
import type { HeroSlice } from "~/types/prismic";
import { asHTML } from "@prismicio/helpers";

const props = defineProps<{ slice: HeroSlice }>();
</script>

<template>
  <section class="hero">
    <h1>{{ slice.primary.header }}</h1>
    <div v-html="asHTML(slice.primary.text)"></div>

    <PrismicLink
      v-if="slice.primary.button_link"
      :field="slice.primary.button_link"
      class="btn btn-primary"
    >
      {{ slice.primary.button_text || "Knop" }}
    </PrismicLink>
  </section>
</template>

<style scoped>
.hero {
  padding: 4rem 2rem;
  text-align: center;
  background-color: #f5f5f5;
}

.hero h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
}

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
</style>