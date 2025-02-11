<template>
  <pre v-if="dev" class="debug-permissions">
    <code>{{ permissions }}</code>
  </pre>
</template>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { computed } from "vue";

const auth = useAuthStore();
const permissions = computed(() =>
  JSON.stringify(auth.user?.roles?.[0]?.permissions, null, 2),
);
const dev = import.meta.env.DEV;
</script>

<style scoped>
.debug-permissions {
  background: #f5f5f5;
  padding: 1rem;
  border-radius: 4px;
  margin: 1rem 0;
  font-size: 0.875rem;
}
</style>
