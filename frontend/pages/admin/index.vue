<script setup lang="ts">
definePageMeta({
  middleware: async (to, from) => {
    const auth = useAuthStore()
    if (!auth.isAuthenticated) {
      return navigateTo('/login')
    }
  }
})

const auth = useAuthStore()
const route = useRoute()
const tab = ref(route.query.tab?.toString() || 'roles')

onMounted(() => {
  if (!auth.isAdmin) {
    navigateTo('/')
  }
})
</script>

<template>
  <div class="pa-4">
    <VRow>
      <VCol cols="12">
        <h1 class="text-h4 mb-4">Admin Dashboard</h1>
        <VTabs v-model="tab">
          <VTab value="roles">Roles</VTab>
          <VTab value="users">Users</VTab>
          <VTab value="permissions">Permissions</VTab>
        </VTabs>

        <VWindow v-model="tab" class="mt-4">
          <VWindowItem value="roles">
            <RoleManagement />
          </VWindowItem>
          <VWindowItem value="users">
            <UserManagement />
          </VWindowItem>
          <VWindowItem value="permissions">
            <PermissionManagement />
          </VWindowItem>
        </VWindow>
      </VCol>
    </VRow>
  </div>
</template>