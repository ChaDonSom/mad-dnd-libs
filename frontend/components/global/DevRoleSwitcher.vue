<script setup lang="ts">
const auth = useAuthStore()
const config = useRuntimeConfig()

interface TestUser {
  name: string
  email: string
  password: string
  role: string
}

const testUsers: TestUser[] = [
  {
    name: 'Admin User',
    email: 'admin@example.com',
    password: 'password123',
    role: 'admin'
  },
  {
    name: 'Host User',
    email: 'host@example.com',
    password: 'password123',
    role: 'host'
  },
  {
    name: 'Player User',
    email: 'player@example.com',
    password: 'password123',
    role: 'player'
  }
]

async function loginAsUser(user: TestUser) {
  const result = await auth.login(user.email, user.password)
  if (result !== true) {
    // If login fails, try registering first
    const registerResult = await auth.register(
      user.name,
      user.email,
      user.password,
      user.password
    )
    if (registerResult !== true) {
      console.error('Failed to create test user:', registerResult.message)
    }
  }
}
</script>

<template>
  <VCard v-if="config.public.nodeEnv === 'development'" class="mt-4 pa-4">
    <VCardTitle class="d-flex align-center">
      <span>Dev Role Switcher</span>
      <VSpacer />
      <VChip color="warning" small>Development Mode</VChip>
    </VCardTitle>
    <VCardText>
      <div class="d-flex flex-wrap gap-2">
        <VBtn
          v-for="user in testUsers"
          :key="user.email"
          :color="auth.user?.email === user.email ? 'primary' : ''"
          variant="outlined"
          @click="loginAsUser(user)"
        >
          Login as {{ user.role }}
        </VBtn>
      </div>
    </VCardText>
  </VCard>
</template>