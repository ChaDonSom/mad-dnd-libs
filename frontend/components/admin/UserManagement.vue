<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface User {
  id: number
  name: string
  email: string
  roles: {
    id: number
    name: string
    permissions?: {
      id: number
      name: string
      slug: string
    }[]
  }[]
}

const users = ref<User[]>([])
const loading = ref(false)
const editingUser = ref<User | null>(null)
const dialog = ref(false)

const config = useRuntimeConfig()
const auth = useAuthStore()

async function fetchUsers() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/users?include=roles`, {
      headers: {
        Authorization: `Bearer ${auth.token}`,
      }
    })
    users.value = await response.json()
  } catch (error) {
    console.error('Error fetching users:', error)
  } finally {
    loading.value = false
  }
}

async function deleteUser(id: number) {
  if (!confirm('Are you sure you want to delete this user?')) return

  try {
    await fetch(`${config.public.apiUrl}/api/users/${id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${auth.token}`,
      }
    })
    fetchUsers()
  } catch (error) {
    console.error('Error deleting user:', error)
  }
}

onMounted(() => {
  fetchUsers()
})
</script>

<template>
  <div>
    <div class="d-flex align-center mb-4">
      <h2 class="text-h5 mr-4">Users</h2>
      <VSpacer />
      <VBtn
        color="primary"
        prepend-icon="mdi-plus"
        @click="dialog = true"
      >
        Add User
      </VBtn>
    </div>

    <VTable v-if="users.length">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Roles</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <VChip
              v-for="role in user.roles"
              :key="role.id"
              size="small"
              class="mr-1"
            >
              {{ role.name }}
            </VChip>
          </td>
          <td>
            <VBtn
              icon="mdi-pencil"
              size="small"
              variant="text"
              @click="editingUser = user; dialog = true"
            />
            <VBtn
              icon="mdi-delete"
              size="small"
              variant="text"
              color="error"
              @click="deleteUser(user.id)"
            />
          </td>
        </tr>
      </tbody>
    </VTable>
    <VSkeletonLoader v-else-if="loading" type="table" />
    <VAlert v-else type="info" variant="tonal">
      No users found. Create one to get started.
    </VAlert>

    <!-- User Edit Dialog -->
    <VDialog v-model="dialog" max-width="500px">
      <VCard>
        <VCardTitle>
          {{ editingUser ? 'Edit User' : 'New User' }}
        </VCardTitle>
        <VCardText>
          <UserForm
            :user="editingUser"
            @saved="dialog = false; fetchUsers()"
            @cancel="dialog = false"
          />
        </VCardText>
      </VCard>
    </VDialog>
  </div>
</template>