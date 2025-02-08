<script setup lang="ts">
import { usePreferredDark } from "@vueuse/core";
import { useTheme } from "vuetify";

const auth = useAuthStore();
const router = useRouter();

const prefersDark = usePreferredDark();
const theme = useTheme();

// Set theme based on system preference
watch(
  prefersDark,
  (newValue) => {
    theme.global.name.value = newValue ? "dark" : "light";
  },
  { immediate: true },
);

async function handleLogout() {
  const success = await auth.logout();
  if (success) {
    router.push("/login");
  }
}
</script>

<template>
  <div>
    <VAppBar>
      <VAppBarTitle>Mad D&D Libs</VAppBarTitle>
      <VSpacer />
      <template v-if="auth.user">
        <VBtn @click="handleLogout">Logout</VBtn>
      </template>
      <template v-else>
        <VBtn to="/login">Login</VBtn>
        <VBtn to="/register" class="ml-2">Register</VBtn>
      </template>
    </VAppBar>

    <VMain>
      <slot />
    </VMain>
  </div>
</template>
