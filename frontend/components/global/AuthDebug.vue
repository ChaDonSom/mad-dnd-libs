<script setup lang="ts">
const auth = useAuthStore();
</script>

<template>
  <VCard v-if="auth.user" class="mt-4 pa-4">
    <VCardTitle>Auth Debug Info</VCardTitle>
    <VCardText>
      <pre>User: {{ auth.user.name }} ({{ auth.user.email }})</pre>
      <pre>Roles: {{ auth.user.roles?.join(', ') || 'None' }}</pre>
      <pre>Permissions: {{ auth.user.permissions?.join(', ') || 'None' }}</pre>
      <pre>Token Present: {{ !!auth.token }}</pre>
    </VCardText>
  </VCard>
</template>