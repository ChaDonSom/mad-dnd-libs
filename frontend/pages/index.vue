<template>
  <div>
    <h1>Welcome to Mad DnD Libs: The Chaotic Quest!</h1>
    <p>Join us in creating absurd characters and battling in a hilarious multiplayer experience.</p>
    <NuxtLink to="/game">Start Game</NuxtLink>
    <NuxtPage />
  </div>
</template>

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

<style scoped>
h1 {
  color: #ff6347;
}
</style>
