import axios from "axios";
import router from "@/router";

class ApiService {
    constructor() {
        this.apiClient = axios.create({
            baseURL: import.meta.env.VITE_APP_API_URL || "http://localhost/api",
            withCredentials: true,
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
        });

        this._setupInterceptors();
    }

    _setupInterceptors() {
        this.apiClient.interceptors.request.use(
            (config) => {
                const token = localStorage.getItem("token");
                if (token) {
                    config.headers.Authorization = `Bearer ${token}`;
                }
                return config;
            },
            (error) => Promise.reject(error)
        );

        this.apiClient.interceptors.response.use(
            (response) => response.data,
            (error) => {
                if (error.response) {
                    if (error.response.status === 401) {
                        localStorage.removeItem("token");
                        router.push({ name: "login" });
                    }
                    if (error.response.status === 422) {
                        return Promise.reject(error.response.data);
                    }
                }
                return Promise.reject(error);
            }
        );
    }

    get(url, params = {}) {
        return this.apiClient.get(url, { params });
    }

    post(url, data) {
        return this.apiClient.post(url, data);
    }

    put(url, data) {
        return this.apiClient.put(url, data);
    }

    delete(url) {
        return this.apiClient.delete(url);
    }
}

export default new ApiService();
