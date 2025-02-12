<script setup lang="ts">
const auth = useAuthStore()
</script>

<template>
  <VContainer class="fill-height">
    <VRow align="center" justify="center">
      <VCol cols="12" md="8" class="text-center">
        <h1 class="text-h2 mb-6">Mad D&D Libs: The Chaotic Quest!</h1>
        <p class="text-h6 mb-6">
          Join us in creating absurd characters and battling in a hilarious
          multiplayer experience.
        </p>

        <div v-if="auth.user">
          <VBtn to="/game" color="primary" size="x-large" class="mx-2">
            Start Game
          </VBtn>
        </div>
        <div v-else>
          <VBtn to="/login" color="primary" size="x-large" class="mx-2">
            Login to Play
          </VBtn>
          <VBtn to="/register" color="secondary" size="x-large" class="mx-2">
            Register
          </VBtn>
        </div>
      </VCol>
    </VRow>
  </VContainer>
</template>
