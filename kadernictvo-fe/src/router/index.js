import { createRouter, createWebHistory } from 'vue-router';
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import PageNotFoundView from "@/views/PageNotFoundView.vue";
import DashboardView from "@/views/dashboard/DashboardView.vue";
import ProfileView from "@/views/dashboard/ProfileView.vue";
import CalendarView from '@/views/dashboard/CalendarView.vue'
import ReservationView from '@/views/ReservationView.vue';
import store from "../store";

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
        path: '/reservation',
        name: 'reservation',
        component: ReservationView
    },
    {
        path: '/:pathMatch(.*)*',
        component: PageNotFoundView
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
        meta: { requiresAuth: true }
    },
    {
        path: '/profile',
        name: 'profile',
        component: ProfileView,
        beforeEnter: isAuthenticated
    },
    {
        path: '/calendar',
        name: 'calendar',
        component: CalendarView,
        beforeEnter: isAuthenticated
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

function isAuthenticated(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}




router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        isAuthenticated(to, from, next);
    } else {
        next();
    }
});

export default router;
