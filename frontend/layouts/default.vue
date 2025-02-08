<script setup lang="ts">
const auth = useAuthStore();
const router = useRouter();

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
  </VApp>
</template>
