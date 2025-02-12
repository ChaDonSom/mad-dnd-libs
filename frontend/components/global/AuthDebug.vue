<script setup lang="ts">
const auth = useAuthStore();
</script>

<template>
  <VCard v-if="auth.user" class="mt-4 pa-4">
    <VCardTitle class="d-flex align-center">
      <span>Auth Debug Info</span>
      <VSpacer />
      <VChip color="warning" small>Development Mode</VChip>
    </VCardTitle>
    <VCardText>
      <div class="text-body-1 font-weight-bold mb-2">User Information:</div>
      <pre class="pa-2 rounded border overflow-x-auto"><span v-if="auth.user">Name: {{ auth.user.name }}
Email: {{ auth.user.email }}
Roles: {{ auth.user.roles?.map(r => r.name)?.join(', ') || 'None' }}
Permissions: {{ auth.user.roles?.flatMap(r => r.permissions?.map(p => p.name))?.join(', ') || 'None' }}
Token Present: {{ !!auth.token }}</span></pre>
    </VCardText>
  </VCard>
</template>