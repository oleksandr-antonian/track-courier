import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import ThemePreset from './theme.js';
import router from './router';
import {useAuthStore} from "./store";
import 'primeicons/primeicons.css';

const pinia = createPinia();
const app = createApp(App);

app.use(PrimeVue, {
    theme: {
        preset: ThemePreset,
        options: {
            darkModeSelector: '.dark-mode',
        }
    }
});
app.use(pinia);

const authStore = useAuthStore();

authStore.initializeAuth().then(() => {
    app.use(ToastService);
    app.use(ConfirmationService);
    app.use(router);
    app.mount('#app');
});
