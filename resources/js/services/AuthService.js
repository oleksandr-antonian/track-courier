import ApiService from './ApiService';

export default {
    login(email, password) {
       try {
           const credentials = {
               email: email,
               password: password,
           };
           return ApiService.post('/auth/login', credentials);
       } catch (error) {
           throw error;
       }
    },
    logout() {
        try {
            return ApiService.post('/auth/logout');
        } catch (error) {
            throw error;
        }
    },
    getUser() {
        try {
            return ApiService.get('/auth/user');
        } catch (error) {
            throw error;
        }
    }
};
