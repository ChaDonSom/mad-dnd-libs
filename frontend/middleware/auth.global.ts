export default defineNuxtRouteMiddleware((to) => {
  const auth = useAuthStore()
  const guestOnlyPages = ["/login", "/register"]
  const publicPages = ["/", ...guestOnlyPages]

  // Redirect away from guest-only pages when authenticated
  if (guestOnlyPages.includes(to.path) && auth.isAuthenticated) {
    return navigateTo("/")
  }

  // Redirect to login for authenticated-only pages
  if (!publicPages.includes(to.path) && !auth.isAuthenticated) {
    // Store the intended destination
    if (to.path !== "/login") {
      return navigateTo(`/login?redirect=${encodeURIComponent(to.fullPath)}`)
    }
    return navigateTo("/login")
  }
})
