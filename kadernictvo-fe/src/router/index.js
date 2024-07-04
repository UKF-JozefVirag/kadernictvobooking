import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import PageNotFoundView from '@/views/PageNotFoundView.vue'
import DashboardView from '@/views/dashboard/DashboardView.vue'
import ProfileView from '@/views/dashboard/ProfileView.vue'
import CalendarView from '@/views/dashboard/CalendarView.vue'
import ReservationView from '@/views/ReservationView.vue'
import axios from 'axios'

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
        beforeEnter: isAuthenticated
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
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

async function fetchUser() {
    try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.get('http://localhost:8000/api/user', {
            headers: {
                Authorization: `Bearer ${decodeURIComponent($cookies.get('token'))}`
            }
        });
        return response.data;
    } catch (error) {
        console.log('Error fetching user:', error);
        return null;
    }
}

async function isAuthenticated(to, from, next) {
    const user = await fetchUser();
    if (user) {
        next();
    } else {
        next({ name: 'login' });
    }
}

export default router
