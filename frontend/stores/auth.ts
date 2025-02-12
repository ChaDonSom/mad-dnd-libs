import { defineStore } from "pinia";

interface User {
  id: number;
  name: string;
  email: string;
  roles?: {
    id: number;
    name: string;
    slug: string;
    permissions?: {
      id: number;
      name: string;
      slug: string;
    }[];
  }[];
}

interface AuthState {
  user: User | null;
  token: string | null;
  cachedPermissions: string[] | null;
}

interface AuthError {
  message: string;
  errors?: Record<string, string[]>;
}

export const useAuthStore = defineStore("auth", {
  state: (): AuthState => ({
    user: null,
    token: null,
    cachedPermissions: null,
  }),

  getters: {
    isAuthenticated(): boolean {
      return !!this.token;
    },
    
    allPermissions(): string[] {
      if (this.cachedPermissions) return this.cachedPermissions;
      
      const permissions = this.user?.roles?.flatMap(role => 
        role.permissions?.map(permission => permission.slug) ?? []
      ) ?? [];
      
      this.cachedPermissions = [...new Set(permissions)];
      return this.cachedPermissions;
    },

    roles(): string[] {
      return this.user?.roles?.map(role => role.slug) ?? [];
    },
    
    hasRole(): (role: string) => boolean {
      return (role: string) => this.roles.includes(role);
    },
    
    hasPermission(): (permission: string) => boolean {
      return (permission: string) => this.allPermissions.includes(permission);
    },

    // Convenience getters for common role checks
    isAdmin(): boolean {
      return this.hasRole('admin');
    },

    isHost(): boolean {
      return this.hasRole('host');
    },

    isPlayer(): boolean {
      return this.hasRole('player');
    }
  },

  actions: {
    // Reset cached permissions when user state changes
    resetCache() {
      this.cachedPermissions = null;
    },

    async login(email: string, password: string): Promise<AuthError | true> {
      const config = useRuntimeConfig();
      try {
        const response = await fetch(`${config.public.apiUrl}/api/login`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          credentials: "include",
          body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
          return {
            message: data.message || "Login failed",
            errors: data.errors
          };
        }

        this.user = data.user;
        this.token = data.token;
        this.resetCache();
        return true;
      } catch (error) {
        console.error("Login error:", error);
        return { message: "Network error occurred" };
      }
    },

    async register(
      name: string,
      email: string,
      password: string,
      password_confirmation: string,
    ): Promise<AuthError | true> {
      const config = useRuntimeConfig();
      try {
        const response = await fetch(`${config.public.apiUrl}/api/register`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          credentials: "include",
          body: JSON.stringify({
            name,
            email,
            password,
            password_confirmation,
          }),
        });

        const data = await response.json();

        if (!response.ok) {
          return {
            message: data.message || "Registration failed",
            errors: data.errors
          };
        }

        this.user = data.user;
        this.token = data.token;
        this.resetCache();
        return true;
      } catch (error) {
        console.error("Registration error:", error);
        return { message: "Network error occurred" };
      }
    },

    async logout() {
      const config = useRuntimeConfig();
      try {
        if (!this.token) return;

        await fetch(`${config.public.apiUrl}/api/logout`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${this.token}`,
            "Content-Type": "application/json",
          },
        });

        this.user = null;
        this.token = null;
        this.resetCache();
        return true;
      } catch (error) {
        console.error("Logout error:", error);
        return false;
      }
    }
  },
});
