<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

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
const editingRole = ref<Role | null>(null)
const dialog = ref(false)

const config = useRuntimeConfig()

async function fetchRoles() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/roles`, {
      headers: {
        Authorization: `Bearer ${useAuthStore().token}`,
      }
    })
    roles.value = await response.json()
  } catch (error) {
    console.error('Error fetching roles:', error)
  } finally {
    loading.value = false
  }
}

async function deleteRole(id: number) {
  if (!confirm('Are you sure you want to delete this role?')) return

  try {
    await fetch(`${config.public.apiUrl}/api/roles/${id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${useAuthStore().token}`,
      }
    })
    fetchRoles()
  } catch (error) {
    console.error('Error deleting role:', error)
  }
}

onMounted(() => {
  fetchRoles()
})
</script>

<template>
  <div>
    <div class="d-flex align-center mb-4">
      <h2 class="text-h5 mr-4">Roles</h2>
      <VSpacer />
      <VBtn
        color="primary"
        prepend-icon="mdi-plus"
        @click="dialog = true"
      >
        Add Role
      </VBtn>
    </div>

    <VTable v-if="roles.length">
      <thead>
        <tr>
          <th>Name</th>
          <th>Permissions</th>
          <th>Actions</th>
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
          <td>
            <VBtn
              icon="mdi-pencil"
              size="small"
              variant="text"
              @click="editingRole = role; dialog = true"
            />
            <VBtn
              icon="mdi-delete"
              size="small"
              variant="text"
              color="error"
              @click="deleteRole(role.id)"
            />
          </td>
        </tr>
      </tbody>
    </VTable>
    <VSkeletonLoader v-else-if="loading" type="table" />
    <VAlert v-else type="info" variant="tonal">
      No roles found. Create one to get started.
    </VAlert>

    <!-- Role Edit Dialog -->
    <VDialog v-model="dialog" max-width="500px">
      <VCard>
        <VCardTitle>
          {{ editingRole ? 'Edit Role' : 'New Role' }}
        </VCardTitle>
        <VCardText>
          <RoleForm
            :role="editingRole"
            @saved="dialog = false; fetchRoles()"
            @cancel="dialog = false"
          />
        </VCardText>
      </VCard>
    </VDialog>
  </div>
</template>