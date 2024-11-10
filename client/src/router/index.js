import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import { useAuthStore } from '../stores/Auth'; // Make sure this is the correct path to your Auth store
import VerifyEmail from '@/views/VerifyEmail.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { requiresAuth: true }, // Protect this route
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { guestOnly: true }, // Accessible only to guests
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: { guestOnly: true }, // Accessible only to guests
  },
  {
    path: '/verify-email',
    name: 'verify-email', // The name of the route
    component: VerifyEmail,
    meta: { guestOnly: true }, // Accessible only to guests
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// Navigation Guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  // If authentication check is not in progress
  if (!authStore.checkingAuth) {
    await authStore.checkAuthStatus(); // Ensure the user's auth status is up-to-date
  }

  const isAuthenticated = authStore.authenticated;

  if (to.meta.requiresAuth && !isAuthenticated) {
    // Redirect to login if the user is not authenticated
    next('/login');
  } else if (to.meta.guestOnly && isAuthenticated) {
    // Redirect to home if the user is authenticated and trying to access guest-only routes
    next('/');
  } else {
    next(); // Proceed to the route
  }
});

export default router;
