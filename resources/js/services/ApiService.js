import axios from 'axios';
import router from '@/router';

const API_URL = import.meta.env.VITE_APP_API_URL || 'http://localhost/api';

const apiClient = axios.create({
    baseURL: API_URL,
    withCredentials: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
});

apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

apiClient.interceptors.response.use(
    (response) => {
        return response.data;
    },
    (error) => {
        if (error.response) {
            if (error.response.status === 401) {
                localStorage.removeItem('token');
                router.push({ name: 'login' });
            }
            if (error.response.status === 422) {
                return Promise.reject(error.response.data);
            }
        }
        return Promise.reject(error);
    }
);

export default {
    get(url, params = {}) {
        return apiClient.get(url, { params });
    },

    post(url, data) {
        return apiClient.post(url, data);
    },

    put(url, data) {
        return apiClient.put(url, data);
    },

    delete(url) {
        return apiClient.delete(url);
    },
};
