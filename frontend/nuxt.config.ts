// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
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
  runtimeConfig: {
    public: {
      nodeEnv: process.env.NODE_ENV || 'development',
      apiUrl: process.env.NUXT_PUBLIC_API_URL || 'http://localhost:8000'
    }
  },
  vuetify: {
    moduleOptions: {
      styles: true,
    },
    vuetifyOptions: {
      defaults: {
        VBtn: {
          rounded: "pill",
          style: "text-transform: none;",
        },
        VTextField: {
          variant: "outlined",
          rounded: "pill",
        },
        VCard: {
          rounded: "xl",
        },
        VDialog: {
          rounded: "xl",
        },
        VChip: {
          rounded: "pill",
        },
        VIcon: {
          iconfont: "mdi",
        },
      },
      display: {
        mobileBreakpoint: "sm",
      },
      theme: {
        defaultTheme: "light", // Set a default theme
        themes: {
          light: {
            colors: {
              primary: "#1867C0",
              secondary: "#5CBBF6",
            },
          },
          dark: {
            colors: {
              primary: "#1867C0",
              secondary: "#5CBBF6",
            },
          },
        },
      },
    },
  },

  build: {
    transpile: ["vuetify"],
  },

  compatibilityDate: "2025-02-07",

  app: {
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
        {
          name: "color-scheme",
          content: "light dark",
        },
      ],
      link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }],
      htmlAttrs: {
        "data-color-scheme": "light dark",
      },
    },
  },
});
