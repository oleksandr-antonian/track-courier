import {defineStore} from "pinia";
import CourierService from "@/services/CourierService";

const useCourierStore = defineStore("courier", {
    state: () => ({
        availabilityStatuses: [],
        transportTypes: [],
        couriers: [],
        pagination: { total: 0, per_page: 10, current_page: 1 },
        loading: false
    }),

    actions: {
        async fetchAvailabilityStatuses() {
            try {
                if (this.availabilityStatuses.length) {
                    return;
                }
                const response = await CourierService.getAvailabilityStatuses();
                this.availabilityStatuses = response.data;
            } catch (error) {
                throw error;
            }
        },
        async fetchTransportTypes() {
            try {
                if (this.transportTypes.length) {
                    return;
                }
                const response = await CourierService.getTransportTypes();
                this.transportTypes = response.data;
            } catch (error) {
                throw error;
            }
        },
        async fetchCouriers(page = 1, perPage = 10, filters = {}) {
            try {
                this.loading = true;
                const response = await CourierService.getCouriers(page, perPage, filters);
                this.couriers = response.data.data;
                this.pagination = {
                    total: response.data.total,
                    per_page: response.data.per_page,
                    current_page: response.data.current_page
                }
                return response;
            } catch (error) {
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async deleteCourier(id) {
            try {
                await CourierService.deleteCourier(id);
                this.couriers = this.couriers.filter(courier => courier.id !== id);
            } catch (error) {
                throw error;
            }
        },
        async fetchCourier(id) {
            try {
                return await CourierService.getCourier(id);
            } catch (error) {
                throw error;
            }
        },
        async updateCourier(id, data) {
            try {
                return await CourierService.updateCourier(id, data);
            } catch (error) {
                throw error;
            }
        },
        async createCourier(data) {
            try {
                return await CourierService.createCourier(data);
            } catch (error) {
                throw error;
            }
        }
    },
});

export default useCourierStore;
