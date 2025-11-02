import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { createPinia } from 'pinia';
import App from './components/App.vue';
import routes from './routes';
import { useAuthStore } from './stores/auth';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);

const authStore = useAuthStore();
authStore.initializeAuth();

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next('/login');
    } else if ((to.path === '/login' || to.path === '/register') && authStore.isAuthenticated) {
        next('/recipes');
    } else {
        next();
    }
});

app.mount('#app');