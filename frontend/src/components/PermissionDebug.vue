<template>
  <pre v-if="dev">
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
