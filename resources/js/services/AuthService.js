import ApiService from "./ApiService";

class AuthService {
    async login(email, password) {
        try {
            const credentials = { email, password };
            return await ApiService.post("/auth/login", credentials);
        } catch (error) {
            throw error;
        }
    }

    async logout() {
        try {
            return await ApiService.post("/auth/logout");
        } catch (error) {
            throw error;
        }
    }

    async getUser() {
        try {
            return await ApiService.get("/auth/user");
        } catch (error) {
            throw error;
        }
    }
}

export default new AuthService();
