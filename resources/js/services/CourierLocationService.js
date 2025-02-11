import ApiService from "./ApiService";

class CourierLocationService {
    async updateCourierLocation(id, data) {
        try {
            return await ApiService.post(`/couriers/${id}/locations`, data);
        } catch (error) {
            throw error;
        }
    }
}

export default new CourierLocationService();
