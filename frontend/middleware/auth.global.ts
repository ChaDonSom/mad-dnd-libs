export default defineNuxtRouteMiddleware((to) => {
  const auth = useAuthStore();

  // Public pages that don't require authentication
  const publicPages = ["/login", "/register"];
  const requiresAuth = !publicPages.includes(to.path);

  if (requiresAuth && !auth.token) {
    return navigateTo("/login");
  }

  if (auth.token && publicPages.includes(to.path)) {
    return navigateTo("/");
  }
});
