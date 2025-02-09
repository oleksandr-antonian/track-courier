import { createWebHistory, createRouter } from 'vue-router'
import {useAuthStore} from "@/store";

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/views/HomeView.vue'),
        meta: { middleware: ['auth'] }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('@/views/LoginView.vue'),
        meta: { middleware: ['guest'] }
    },
    {
        path: '/couriers',
        name: 'couriers',
        component: () => import('@/views/CourierView.vue'),
        meta: { middleware: ['auth'] }
    },
    {
        path: '/couriers/:id',
        name: 'courier',
        component: () => import('@/views/CourierDetailView.vue'),
        meta: { middleware: ['auth'] }
    },
    {
        path: '/debug',
        name: 'debug',
        component: () => import('@/views/DebugView.vue'),
        meta: { middleware: ['auth'] }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    const middleware = to.meta.middleware || [];

    if (middleware.includes('auth') && !authStore.isAuthenticated) {
        return next('/login');
    }

    if (middleware.includes('guest') && authStore.isAuthenticated) {
        return next('/');
    }

    if (middleware.includes('admin') && authStore.user?.role !== 'admin') {
        return next('/');
    }

    return next();
});

export default router
