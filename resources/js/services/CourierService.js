import ApiService from "./ApiService";

class CourierService {
    async getAvailabilityStatuses() {
        try {
            return await ApiService.get("/couriers/availability-statuses");
        } catch (error) {
            throw error;
        }
    }

    async getTransportTypes() {
        try {
            return await ApiService.get("/couriers/transport-types");
        } catch (error) {
            throw error;
        }
    }

    async getCouriers(page = 1, perPage = 10, filters = {}) {
        try {
            const params = {
                page: page,
                perPage: perPage,
                ...filters
            };
            return await ApiService.get("/couriers", params);
        } catch (error) {
            throw error;
        }
    }

    async deleteCourier(id) {
        try {
            return await ApiService.delete(`/couriers/${id}`);
        } catch (error) {
            throw error;
        }
    }

    async getCourier(id) {
        try {
            return await ApiService.get(`/couriers/${id}`);
        } catch (error) {
            throw error;
        }
    }

    async updateCourier(id, data) {
        try {
            return await ApiService.put(`/couriers/${id}`, data);
        } catch (error) {
            throw error;
        }
    }

    async createCourier(data) {
        try {
            return await ApiService.post("/couriers", data);
        } catch (error) {
            throw error;
        }
    }
}

export default new CourierService();
