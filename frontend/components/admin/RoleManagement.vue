<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface Role {
  id: number
  name: string
  permissions: Permission[]
}

interface Permission {
  id: number
  name: string
  slug: string
}

const roles = ref<Role[]>([])
const loading = ref(false)

const config = useRuntimeConfig()

async function fetchRoles() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/roles?include=permissions`, {
      headers: {
        Authorization: `Bearer ${useAuthStore().token}`,
      }
    })
    const json = await response.json()
    roles.value = json.data
  } catch (error) {
    console.error('Error fetching roles:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchRoles()
})
</script>

<template>
  <div>
    <h2 class="text-h5 mb-4">Roles</h2>

    <VTable v-if="roles.length">
      <thead>
        <tr>
          <th>Name</th>
          <th>Permissions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="role in roles" :key="role.id">
          <td>{{ role.name }}</td>
          <td>
            <VChip
              v-for="permission in role.permissions"
              :key="permission.id"
              size="small"
              class="mr-1"
            >
              {{ permission.name }}
            </VChip>
          </td>
        </tr>
      </tbody>
    </VTable>
    <VSkeletonLoader v-else-if="loading" type="table" />
    <VAlert v-else type="info" variant="tonal">
      No roles found.
    </VAlert>
  </div>
</template>