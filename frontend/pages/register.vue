<script setup lang="ts">
const auth = useAuthStore();
const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const loading = ref(false);
const errorMessage = ref("");
const validationErrors = ref<Record<string, string[]>>({});

async function handleRegister() {
  loading.value = true;
  errorMessage.value = "";
  validationErrors.value = {};
  
  // Basic validation
  if (password.value !== passwordConfirmation.value) {
    errorMessage.value = "Passwords do not match";
    loading.value = false;
    return;
  }

  const result = await auth.register(
    name.value,
    email.value,
    password.value,
    passwordConfirmation.value,
  );
  loading.value = false;

  if (result === true) {
    router.push("/");
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
      <VCardTitle class="text-center">Register</VCardTitle>
      <VForm @submit.prevent="handleRegister">
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
          v-model="name" 
          label="Name" 
          required
          :error-messages="validationErrors.name"
        />
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
        <VTextField
          v-model="passwordConfirmation"
          label="Confirm Password"
          type="password"
          required
          :error-messages="validationErrors.password_confirmation"
        />
        <VBtn
          type="submit"
          color="primary"
          block
          class="mt-4"
          :loading="loading"
        >
          Register
        </VBtn>
      </VForm>
      <div class="text-center mt-4">
        <NuxtLink to="/login">Already have an account? Login</NuxtLink>
      </div>
    </VCard>
  </div>
</template>
