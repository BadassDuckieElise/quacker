import { apiEndpoint, repositoryName } from "./slicemachine.config.json";
import tailwindcss from "@tailwindcss/vite";
// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  modules: ["@nuxtjs/prismic"],
  css: ["./app/assets/css/main.css"],

  prismic: {
    endpoint: apiEndpoint || repositoryName,
    linkResolver: "./prismic/link-resolver",
  },
  vite: {
    plugins: [tailwindcss()]
  },
})