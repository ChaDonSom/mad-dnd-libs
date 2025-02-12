<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface User {
  id: number
  name: string
  email: string
  roles: {
    id: number
    name: string
  }[]
}

interface Role {
  id: number
  name: string
  slug: string
}

const props = defineProps<{
  user?: User | null
}>()

const emit = defineEmits<{
  saved: []
  cancel: []
}>()

const name = ref('')
const email = ref('')
const password = ref('')
const selectedRoles = ref<number[]>([])
const roles = ref<Role[]>([])
const loading = ref(false)
const formLoading = ref(false)
const errors = ref<Record<string, string[]>>({})

const config = useRuntimeConfig()
const auth = useAuthStore()

async function fetchRoles() {
  loading.value = true
  try {
    const response = await fetch(`${config.public.apiUrl}/api/roles`, {
      headers: {
        Authorization: `Bearer ${auth.token}`
      }
    })
    roles.value = await response.json()
  } catch (error) {
    console.error('Error fetching roles:', error)
  } finally {
    loading.value = false
  }
}

async function handleSubmit() {
  formLoading.value = true
  errors.value = {}

  const payload: Record<string, any> = {
    name: name.value,
    email: email.value,
    roles: selectedRoles.value
  }

  // Only include password if it's provided (for edits) or required (for new users)
  if (password.value || !props.user) {
    payload.password = password.value
    payload.password_confirmation = password.value
  }

  try {
    const url = props.user
      ? `${config.public.apiUrl}/api/users/${props.user.id}`
      : `${config.public.apiUrl}/api/users`
    
    const response = await fetch(url, {
      method: props.user ? 'PUT' : 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${auth.token}`
      },
      body: JSON.stringify(payload)
    })

    if (!response.ok) {
      const data = await response.json()
      errors.value = data.errors || {}
      return
    }

    emit('saved')
  } catch (error) {
    console.error('Error saving user:', error)
  } finally {
    formLoading.value = false
  }
}

onMounted(async () => {
  await fetchRoles()
  if (props.user) {
    name.value = props.user.name
    email.value = props.user.email
    selectedRoles.value = props.user.roles.map(r => r.id)
  }
})
</script>

<template>
  <VForm @submit.prevent="handleSubmit">
    <VTextField
      v-model="name"
      label="Name"
      required
      :error-messages="errors.name"
    />

    <VTextField
      v-model="email"
      label="Email"
      type="email"
      required
      :error-messages="errors.email"
    />

    <VTextField
      v-model="password"
      label="Password"
      type="password"
      :placeholder="props.user ? 'Leave blank to keep current password' : 'Enter password'"
      :required="!props.user"
      :error-messages="errors.password"
    />

    <VSelect
      v-model="selectedRoles"
      :items="roles"
      label="Roles"
      item-title="name"
      item-value="id"
      multiple
      chips
      :loading="loading"
      :error-messages="errors.roles"
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