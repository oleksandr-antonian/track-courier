import ApiService from "./ApiService";

class CityService {
    async getCities() {
        try {
            return await ApiService.get("/cities");
        } catch (error) {
            throw error;
        }
    }
}

export default new CityService();
