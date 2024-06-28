import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
    state: {
        authenticated: false,
        authUser: null
    },
    getters: {
        isAuthenticated: (state) => state.authenticated,
        getUser: (state) => state.authUser
    },
    actions: {
        async getToken() {
            try {
                await axios.get('/sanctum/csrf-cookie');
            } catch (e) {
                console.log(e);
                this.authenticated = false;
                this.authUser = null;
            }
        },
        async fetchUser() {
            try {
                await this.getToken();
                const { data } = await axios.get('https://localhost:8000/api/getUserInfo');
                if (data.success) {
                    this.authUser = data;
                    this.authenticated = true;
                } else {
                    this.authUser = null;
                    this.authenticated = false;
                }
            } catch (e) {
                console.log(e);
                this.authUser = null;
                this.authenticated = false;
            }
        },
        logout() {
            this.authUser = null;
            this.authenticated = false;
        },
        async checkAuthentication() {
            if (!this.authenticated) {
                await this.fetchUser();
            }
        }
    }
});
