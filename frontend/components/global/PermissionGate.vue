<script setup lang="ts">
const auth = useAuthStore()

interface Props {
  require?: string | string[] // permission or array of permissions
  requireAll?: boolean // if true, all permissions are required
  role?: string | string[] // role or array of roles
  requireAllRoles?: boolean // if true, all roles are required
}

const props = withDefaults(defineProps<Props>(), {
  requireAll: false,
  requireAllRoles: false,
})

const canAccess = computed(() => {
  if (!auth.isAuthenticated) return false

  const hasRequiredPermissions = () => {
    if (!props.require) return true
    const permissions = Array.isArray(props.require) ? props.require : [props.require]
    return props.requireAll
      ? permissions.every(p => auth.hasPermission(p))
      : permissions.some(p => auth.hasPermission(p))
  }

  const hasRequiredRoles = () => {
    if (!props.role) return true
    const roles = Array.isArray(props.role) ? props.role : [props.role]
    return props.requireAllRoles
      ? roles.every(r => auth.hasRole(r))
      : roles.some(r => auth.hasRole(r))
  }

  return hasRequiredPermissions() && hasRequiredRoles()
})
</script>

<template>
  <slot v-if="canAccess" />
</template>