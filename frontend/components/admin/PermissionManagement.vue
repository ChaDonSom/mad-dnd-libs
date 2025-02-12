<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface Permission {
  id: number
  name: string
  slug: string
  roles?: {
    id: number
    name: string
  }[]
}

const permissions = ref<Permission[]>([])
const loading = ref(false)
const config = useRuntimeConfig()
const auth = useAuthStore()

async function fetchPermissions() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/permissions?include=roles`, {
      headers: {
        Authorization: `Bearer ${auth.token}`,
      }
    })
    const json = await response.json()
    permissions.value = json.data
  } catch (error) {
    console.error('Error fetching permissions:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchPermissions()
})
</script>

<template>
  <div>
    <h2 class="text-h5 mb-4">Permissions</h2>

    <VTable v-if="permissions.length">
      <thead>
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th>Roles</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="permission in permissions" :key="permission.id">
          <td>{{ permission.name }}</td>
          <td><code>{{ permission.slug }}</code></td>
          <td>
            <VChip
              v-for="role in permission.roles"
              :key="role.id"
              size="small"
              class="mr-1"
            >
              {{ role.name }}
            </VChip>
          </td>
        </tr>
      </tbody>
    </VTable>
    <VSkeletonLoader v-else-if="loading" type="table" />
    <VAlert v-else type="info" variant="tonal">
      No permissions found.
    </VAlert>
  </div>
</template>