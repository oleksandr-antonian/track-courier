import ApiService from "./ApiService";

export default {
    async getCities() {
        try {
            return await ApiService.get("/cities");
        } catch (error) {
            throw error;
        }
    }
};
