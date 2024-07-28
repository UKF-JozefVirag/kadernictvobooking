import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import PageNotFoundView from '@/views/PageNotFoundView.vue'
import DashboardView from '@/views/dashboard/DashboardView.vue'
import ProfileView from '@/views/dashboard/ProfileView.vue'
import CalendarView from '@/views/dashboard/CalendarView.vue'
import ReservationView from '@/views/ReservationView.vue'
import axios from 'axios'
import ReservationCompleteView from '@/views/ReservationCompleteView.vue'
import ServicesView from '@/views/dashboard/ServicesView.vue'
import EmployeesView from '@/views/dashboard/EmployeesView.vue'
import axiosInstance from '@/axios.js'

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView,
        beforeEnter: async (to, from, next) => {
            const user = await fetchUser();
            if (user) {
                next({ name: 'dashboard' });
            } else {
                next();
            }
        }
    },
    {
        path: '/reservation',
        name: 'reservation',
        component: ReservationView
    },
    {
        path: '/reservation/complete',
        name: 'reservation-complete',
        component: ReservationCompleteView,
        meta: { requiresReservationView: true },
        beforeEnter: (to, from, next) => {
            if (from.name === 'reservation') {
                next();
            } else {
                next({ name: 'error' });
            }
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'error',
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
    },
    {
        path: '/employee',
        name: 'employees',
        component: EmployeesView,
        beforeEnter: isAuthenticated
    },
    {
        path: '/services',
        name: 'services',
        component: ServicesView,
        beforeEnter: isAuthenticated
    }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

async function fetchUser() {
    try {
        await axios.get('http://localhost:8000/sanctum/csrf-cookie');
        const response = await axiosInstance.get('/user', {
            headers: {
                Authorization: `Bearer ${decodeURIComponent($cookies.get('token'))}`
            }
        });
        return response.data;
    } catch (error) {
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
