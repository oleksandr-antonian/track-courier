import { defineStore } from "pinia";
import CityService from "@/services/CityService";

const useCityStore = defineStore("city", {
    state: () => ({
        cities: [],
    }),

    actions: {
        async fetchCities() {
            try {
                if (this.cities.length) {
                    return;
                }
                const response = await CityService.getCities();
                this.cities = response.data.data;
            } catch (error) {
                throw error;
            }
        },
    },
});

export default useCityStore;
