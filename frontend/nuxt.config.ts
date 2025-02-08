export default defineNuxtConfig({
  head: {
    title: "Mad DnD Libs: The Chaotic Quest",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      {
        hid: "description",
        name: "description",
        content:
          "A multiplayer web-based party game where players create absurd characters and weapons.",
      },
    ],
    link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }],
  },

  css: ["vuetify/lib/styles/main.css", "@mdi/font/css/materialdesignicons.css"],
  plugins: [],
  components: true,
  modules: [
    "@nuxtjs/tailwindcss",
    "@pinia/nuxt",
    "@vueuse/nuxt",
    "@formkit/auto-animate",
    "vuetify-nuxt-module",
  ],

  vuetify: {
    moduleOptions: {
      styles: true, // Remove the configFile option
    },
    vuetifyOptions: {
      defaults: {
        VBtn: {
          rounded: "pill",
          style: "text-transform: none;",
        },
      },
      theme: {
        defaultTheme: "light",
      },
    },
  },

  build: {
    transpile: ["vuetify"],
  },

  server: {
    port: 3000, // default: 3000
    host: "0.0.0.0", // default: localhost
  },

  compatibilityDate: "2025-02-07",
});
