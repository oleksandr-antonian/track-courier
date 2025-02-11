import Echo from "laravel-echo";
import axios from "axios";
import Pusher from "pusher-js";
window.Pusher = Pusher;

class WebSocketService {
    constructor() {
        this.echo = null;
        this.token = null;
    }

    setToken(token) {
        this.token = token;
    }

    connect() {
        if (!this.token) {
            throw new Error("Token is required to connect to WebSocket!");
        }

        this.echo = new Echo({
            broadcaster: "pusher",
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            encrypted: true,
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            authorizer: (channel, options) => {
                return {
                    authorize: (socketId, callback) => {
                        axios
                            .post("/api/broadcasting/auth", {
                                socket_id: socketId,
                                channel_name: channel.name,
                            }, {
                                headers: { Authorization: `Bearer ${this.token}` },
                            })
                            .then((response) => callback(false, response.data))
                            .catch((error) => callback(true, error));
                    },
                };
            },
        });
    }

    disconnect() {
        if (this.echo) {
            this.echo.disconnect();
            this.echo = null;
        }
    }
    isConnected() {
        return this.echo !== null && this.echo.connector !== null;
    }
    getEcho() {
        return this.echo;
    }
}

export default new WebSocketService();
