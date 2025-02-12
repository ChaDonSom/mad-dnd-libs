<script setup lang="ts">
import { usePreferredDark } from "@vueuse/core";
import { useTheme } from "vuetify";

const auth = useAuthStore();
const router = useRouter();
const config = useRuntimeConfig();

const prefersDark = usePreferredDark();
const theme = useTheme();

// Set theme based on system preference
onMounted(() => {
  watch(
    prefersDark,
    (newValue) => {
      theme.global.name.value = newValue ? "dark" : "light";
    },
    { immediate: true },
  );
});

async function handleLogout() {
  const success = await auth.logout();
  if (success) {
    router.push("/login");
  }
}
</script>

<template>
  <VApp>
    <VAppBar>
      <VAppBarTitle>
        <NuxtLink to="/" class="text-decoration-none">Mad DnD Libs</NuxtLink>
      </VAppBarTitle>

      <VSpacer />

      <template v-if="!auth.isAuthenticated">
        <VBtn to="/login">Login</VBtn>
        <VBtn to="/register" class="ml-2">Register</VBtn>
      </template>
      <template v-else>
        <PermissionGate role="host">
          <VBtn to="/host" class="mr-2">Host Dashboard</VBtn>
        </PermissionGate>
        <VBtn to="/games" class="mr-2">Games</VBtn>
        <VMenu>
          <template v-slot:activator="{ props }">
            <VBtn v-bind="props">
              {{ auth.user?.name }}
              <VIcon right>mdi-menu-down</VIcon>
            </VBtn>
          </template>
          <VList>
            <VListItem to="/profile">
              <VListItemTitle>Profile</VListItemTitle>
            </VListItem>
            <PermissionGate role="admin">
              <VListItem to="/admin">
                <template v-slot:prepend>
                  <VIcon>mdi-shield-crown</VIcon>
                </template>
                <VListItemTitle>Admin Dashboard</VListItemTitle>
              </VListItem>
            </PermissionGate>
            <VDivider />
            <VListItem @click="handleLogout">
              <template v-slot:prepend>
                <VIcon>mdi-logout</VIcon>
              </template>
              <VListItemTitle>Logout</VListItemTitle>
            </VListItem>
          </VList>
        </VMenu>
      </template>
    </VAppBar>

    <VMain>
      <slot />
      <div v-if="config.public.nodeEnv === 'development'" class="pa-4">
        <AuthDebug />
        <DevRoleSwitcher />
      </div>
    </VMain>
  </VApp>
</template>
