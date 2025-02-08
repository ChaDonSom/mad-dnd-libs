export default defineNuxtRouteMiddleware((to) => {
  const auth = useAuthStore();
  const publicPages = ["/", "/login", "/register"];

  // Only check auth requirement
  if (!publicPages.includes(to.path) && !auth.isAuthenticated) {
    return navigateTo("/login");
  }
});
