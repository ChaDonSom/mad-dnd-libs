<script setup lang="ts">
const auth = useAuthStore();
const router = useRouter();

const email = ref("");
const password = ref("");
const loading = ref(false);
const errorMessage = ref("");

async function handleLogin() {
  loading.value = true;
  errorMessage.value = "";
  const success = await auth.login(email.value, password.value);
  loading.value = false;

  if (success) {
    router.push("/");
  } else {
    errorMessage.value = "Login failed. Please check your credentials.";
  }
}
</script>

<template>
  <div class="d-flex align-center justify-center" style="height: 100vh">
    <VCard width="400px" class="pa-4">
      <VCardTitle class="text-center">Login</VCardTitle>
      <VForm @submit.prevent="handleLogin">
        <VTextField v-model="email" label="Email" type="email" required />
        <VTextField
          v-model="password"
          label="Password"
          type="password"
          required
        />
        <VBtn
          type="submit"
          color="primary"
          block
          class="mt-4"
          :loading="loading"
        >
          Login
        </VBtn>
      </VForm>
      <div class="text-center mt-4">
        <NuxtLink to="/register">Don't have an account? Register</NuxtLink>
      </div>
    </VCard>
  </div>
</template>
