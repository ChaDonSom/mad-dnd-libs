export default {
  head: {
    title: "Mad DnD Libs: The Chaotic Quest",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      {
        hid: "description",
        name: "description",
        content: "A multiplayer web-based party game where players create absurd characters and weapons.",
      },
    ],
    link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }],
  },

  css: [],
  plugins: [],
  components: true,
  buildModules: ["@nuxtjs/vuetify"],
  modules: ["@nuxtjs/tailwindcss", "vuetify-nuxt-module", "@pinia/nuxt", "@vueuse/nuxt", "@formkit/auto-animate"],

  vuetify: {
    // Custom options for Vuetify
  },

  build: {
    // Build configuration
  },

  server: {
    port: 3000, // default: 3000
    host: "0.0.0.0", // default: localhost
  },

  compatibilityDate: "2025-02-07",

  devtools: true,
}