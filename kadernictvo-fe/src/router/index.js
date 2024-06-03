import { createRouter, createWebHistory } from 'vue-router';
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import PageNotFoundView from "@/views/PageNotFoundView.vue";
import DashboardView from "@/views/DashboardView.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView
    },
    {
        path: '/:pathMatch(.*)*',
        component: PageNotFoundView
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
        beforeEnter: isAuthenticated
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

function isAuthenticated(to, from, next) {
    if (localStorage.getItem('token')) {
        next();
        return;
    }
    router.push({ name: 'login' });
}

router.beforeEach((to, from, next) => {
    const isLoggedIn = !!localStorage.getItem('token');

    if (to.name === 'login' && isLoggedIn) {
        next({ name: 'dashboard' });
    } else {
        next();
    }
});

export default router;
