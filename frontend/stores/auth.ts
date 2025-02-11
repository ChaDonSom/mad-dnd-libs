import { defineStore } from "pinia";

interface User {
  id: number;
  name: string;
  email: string;
}

interface AuthState {
  user: User | null;
  token: string | null;
}

export const useAuthStore = defineStore("auth", {
  state: (): AuthState => ({
    user: null,
    token: null,
  }),

  getters: {
    isAuthenticated(): boolean {
      return !!this.token;
    },
  },

  actions: {
    async login(email: string, password: string) {
      try {
        const response = await fetch("http://localhost:8000/api/login", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          credentials: "include",
          body: JSON.stringify({ email, password }),
        });

        if (!response.ok) throw new Error("Login failed");

        const data = await response.json();
        this.user = data.user;
        this.token = data.token;
        return true;
      } catch (error) {
        console.error("Login error:", error);
        return false;
      }
    },

    async register(
      name: string,
      email: string,
      password: string,
      password_confirmation: string,
    ) {
      try {
        const response = await fetch("http://localhost:8000/api/register", {
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

        if (!response.ok) throw new Error("Registration failed");

        const data = await response.json();
        this.user = data.user;
        this.token = data.token;
        return true;
      } catch (error) {
        console.error("Registration error:", error);
        return false;
      }
    },

    async logout() {
      try {
        if (!this.token) return;

        await fetch("http://localhost:8000/api/logout", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${this.token}`,
            "Content-Type": "application/json",
          },
        });

        this.user = null;
        this.token = null;
        return true;
      } catch (error) {
        console.error("Logout error:", error);
        return false;
      }
    },
  },
});
