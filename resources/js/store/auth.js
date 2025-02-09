import { defineStore } from 'pinia';
import AuthService from '@/services/AuthService';

const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
        isAuthenticated: false,
    }),

    actions: {
        async login(email, password) {
            try {
                const response = await AuthService.login(email, password);
                this.setUser(response.data.user);
                this.setToken(response.data.token);
                return response;
            } catch (error) {
                throw error;
            }
        },

        async logout() {
            try {
                await AuthService.logout();
            } finally {
                this.setUser(null);
                this.setToken(null);
            }
        },

        async fetchUser() {
            try {
                const response = await AuthService.getUser();
                this.setUser(response.data);
                return response;
            } catch (error) {
                await this.logout();
            }
        },

        async initializeAuth() {
            if (this.token) {
                try {
                    await this.fetchUser();
                    this.isAuthenticated = true;
                } catch (error) {
                    console.error('Failed to fetch user', error);
                    await this.logout();
                }
            }
        },

        setUser(user) {
            this.user = user;
        },

        setToken(token) {
            this.token = token;
            this.isAuthenticated = !!token;
            if (token) {
                localStorage.setItem('token', token);
            } else {
                localStorage.removeItem('token');
            }
        },
    }
});

export default useAuthStore;
