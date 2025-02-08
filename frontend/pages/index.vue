<script>
import { NuxtLink, NuxtPage } from "#components"

export default {
  head() {
    return {
      title: "Mad DnD Libs: The Chaotic Quest",
      meta: [
        {
          hid: "description",
          name: "description",
          content:
            "A multiplayer web-based party game where players create absurd characters and battle in a humorous environment.",
        },
      ],
    }
  },
}
</script>

<template>
  <div class="container mx-auto p-4">
    <header class="text-center mb-8">
      <h1 class="text-4xl font-bold text-gray-800">Mad DnD Libs: The Chaotic Quest!</h1>
      <p class="text-lg text-gray-600 mt-2">
        Join us in creating absurd characters and battling in a hilarious multiplayer experience.
      </p>
    </header>

    <main class="flex justify-center">
      <NuxtLink to="/game" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Start Game
      </NuxtLink>
    </main>

    <footer class="mt-8">
      <NuxtPage />
    </footer>
  </div>
</template>
