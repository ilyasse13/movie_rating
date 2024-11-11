import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import { useAuthStore } from '../stores/Auth';
import VerifyEmail from '@/views/VerifyEmail.vue';
import About from '@/views/About.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'about',
        name: 'about',
        component: About,
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { guestOnly: true },
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: { guestOnly: true },
  },
  {
    path: '/verify-email',
    name: 'verify-email',
    component: VerifyEmail,
    meta: { guestOnly: true },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// Global navigation guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  // Check the user's authentication status
  if (!authStore.checkingAuth) {
    await authStore.checkAuthStatus(); // This will set authenticated status
  }

  const isAuthenticated = authStore.authenticated;
  const isVerified = authStore.user?.isVerified;

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.meta.guestOnly && isAuthenticated) {
    next('/');
  } else {
    next(); // Proceed to the intended route
  }
});

export default router;
