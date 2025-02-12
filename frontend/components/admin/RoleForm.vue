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

const props = defineProps<{
  role?: Role | null
}>()

const emit = defineEmits<{
  saved: []
  cancel: []
}>()

const name = ref('')
const selectedPermissions = ref<number[]>([])
const permissions = ref<Permission[]>([])
const loading = ref(false)
const formLoading = ref(false)
const errors = ref<Record<string, string[]>>({})

const config = useRuntimeConfig()
const auth = useAuthStore()

async function fetchPermissions() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/permissions`, {
      headers: {
        Authorization: `Bearer ${auth.token}`
      }
    })
    permissions.value = await response.json()
  } catch (error) {
    console.error('Error fetching permissions:', error)
  } finally {
    loading.value = false
  }
}

async function handleSubmit() {
  formLoading.value = true
  errors.value = {}

  try {
    const url = props.role
      ? `${config.public.apiUrl}/api/roles/${props.role.id}`
      : `${config.public.apiUrl}/api/roles`
    
    const response = await fetch(url, {
      method: props.role ? 'PUT' : 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${auth.token}`
      },
      body: JSON.stringify({
        name: name.value,
        permissions: selectedPermissions.value
      })
    })

    if (!response.ok) {
      const data = await response.json()
      errors.value = data.errors || {}
      return
    }

    emit('saved')
  } catch (error) {
    console.error('Error saving role:', error)
  } finally {
    formLoading.value = false
  }
}

onMounted(async () => {
  await fetchPermissions()
  if (props.role) {
    name.value = props.role.name
    selectedPermissions.value = props.role.permissions.map(p => p.id)
  }
})
</script>

<template>
  <VForm @submit.prevent="handleSubmit">
    <VTextField
      v-model="name"
      label="Role Name"
      required
      :error-messages="errors.name"
    />

    <VSelect
      v-model="selectedPermissions"
      :items="permissions"
      label="Permissions"
      item-title="name"
      item-value="id"
      multiple
      chips
      :loading="loading"
      :error-messages="errors.permissions"
    />

    <VCardActions>
      <VSpacer />
      <VBtn
        variant="text"
        @click="emit('cancel')"
      >
        Cancel
      </VBtn>
      <VBtn
        color="primary"
        type="submit"
        :loading="formLoading"
      >
        Save
      </VBtn>
    </VCardActions>
  </VForm>
</template>