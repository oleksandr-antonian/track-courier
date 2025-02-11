import {defineStore} from "pinia";
import WebSocketService from "../services/WebSocketService.js";
import CourierLocationService from "../services/CourierLocationService.js";
import useAuthStore from "./AuthStore.js";

const useCourierLocationStore = defineStore("courierLocation", {
    state: () => ({
        courierLocations: [],
    }),
    actions: {
        async listenToCourierLocationUpdates() {
            try {
                if (!WebSocketService.isConnected()) {
                    const token = useAuthStore().token;
                    WebSocketService.setToken(token);
                    WebSocketService.connect();
                }
                WebSocketService.getEcho()
                    .private("couriers.locations")
                    .listen("CourierLocationUpdated", (event) => {
                        const index = this.courierLocations.findIndex(courierLocation => courierLocation.courier_id === event.courier_id);
                        if (index !== -1) {
                            this.courierLocations[index] = event;
                        } else {
                            this.courierLocations.push(event);
                        }
                    });
            } catch (error) {
                throw error;
            }
        },
        async stopListeningToCourierLocationUpdates() {
            try {
                if (WebSocketService.isConnected()) {
                    WebSocketService.getEcho().leave("couriers.locations");
                }
            } catch (error) {
                throw error;
            }
        },
        async updateCourierLocation(id, data) {
            try {
                return await CourierLocationService.updateCourierLocation(id, data);
            } catch (error) {
                throw error;
            }
        }
    }
});

export default useCourierLocationStore;
