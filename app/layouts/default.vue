<template>
<main>
<header>
    <h1>{{ settings.data.header }}</h1>
</header>
<article>
<!-- In dit slot element worden de pages geladen -->
<slot />
</article>
</main>
</template>

<script setup lang="ts">
import { usePrismic } from '#imports'
import { ref, onMounted } from 'vue'

const { client } = usePrismic()
const headerTitle = ref('Mijn Website')
const settings = await client.getSingle('settings')


</script>

<style scoped>
header {
  background-color: #f5f5f5;
  padding: 20px;
  /* border-bottom: 2px solid #333; */
}

header h1 {
  margin: 0;
  font-size: 2rem;
  color: #333;
}

article {
  padding: 20px;
}
</style>