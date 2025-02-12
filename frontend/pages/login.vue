<script setup lang="ts">
const auth = useAuthStore();
const router = useRouter();
const route = useRoute();

const email = ref("");
const password = ref("");
const loading = ref(false);
const errorMessage = ref("");
const validationErrors = ref<Record<string, string[]>>({});

async function handleLogin() {
  loading.value = true;
  errorMessage.value = "";
  validationErrors.value = {};
  
  const result = await auth.login(email.value, password.value);
  loading.value = false;

  if (result === true) {
    const redirect = route.query.redirect as string;
    router.push(redirect || "/");
  } else {
    errorMessage.value = result.message;
    if (result.errors) {
      validationErrors.value = result.errors;
    }
  }
}
</script>

<template>
  <div class="d-flex align-center justify-center" style="height: 100vh">
    <VCard width="400px" class="pa-4">
      <VCardTitle class="text-center">Login</VCardTitle>
      <VForm @submit.prevent="handleLogin">
        <VAlert
          v-if="errorMessage"
          type="error"
          variant="tonal"
          class="mb-4"
          closable
          @click:close="errorMessage = ''"
        >
          {{ errorMessage }}
        </VAlert>
        <VTextField 
          v-model="email" 
          label="Email" 
          type="email" 
          required
          :error-messages="validationErrors.email"
        />
        <VTextField
          v-model="password"
          label="Password"
          type="password"
          required
          :error-messages="validationErrors.password"
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
