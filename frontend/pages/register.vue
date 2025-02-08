<script setup lang="ts">
const auth = useAuthStore();
const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const loading = ref(false);

async function handleRegister() {
  loading.value = true;
  const success = await auth.register(
    name.value,
    email.value,
    password.value,
    passwordConfirmation.value,
  );
  loading.value = false;

  if (success) {
    router.push("/");
  } else {
    alert("Registration failed");
  }
}
</script>

<template>
  <div class="d-flex align-center justify-center" style="height: 100vh">
    <VCard width="400px" class="pa-4">
      <VCardTitle class="text-center">Register</VCardTitle>
      <VForm @submit.prevent="handleRegister">
        <VTextField v-model="name" label="Name" required />
        <VTextField v-model="email" label="Email" type="email" required />
        <VTextField
          v-model="password"
          label="Password"
          type="password"
          required
        />
        <VTextField
          v-model="passwordConfirmation"
          label="Confirm Password"
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
          Register
        </VBtn>
      </VForm>
      <div class="text-center mt-4">
        <NuxtLink to="/login">Already have an account? Login</NuxtLink>
      </div>
    </VCard>
  </div>
</template>
