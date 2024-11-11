import { ref } from 'vue';
import { defineStore } from 'pinia';
import axiosClient from '@/api/axios';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);  // The authenticated user's data
    const checkingAuth = ref(false);  // Boolean indicating if auth status is being checked
    const authenticated = ref(false);  // Boolean to track authentication status
    const errorMessage = ref('');
    const router = useRouter();

    // Set user data
    const setUser = (userData) => {
        user.value = userData;
    };

    // Check authentication status by calling the API
    const checkAuthStatus = async () => {
        checkingAuth.value = true;
        try {
            const response = await axiosClient.get('/user');
            setUser(response.data.user);
            authenticated.value = true;
        } catch (error) {
            console.error('Error checking auth status:', error.response ? error.response.data : error.message);
            setUser(null);
            authenticated.value = false;
        } finally {
            checkingAuth.value = false;
        }
    };

    // Register a new user
    const register = async (userData) => {
        try {
            const response = await axiosClient.post('/register', userData);
            console.log('Registration successful:', response.data.message);
            router.push('/verify-email');  // Adjust the route path if necessary
        } catch (error) {
            errorMessage.value = error.response ? error.response.data.message : 'Registration failed';
            console.error('Error registering user:', errorMessage.value);
        }
    };

    // Login a user
    const login = async (credentials) => {
        errorMessage.value = '';
        try {
            const response = await axiosClient.post('/login', credentials);
            const token = response.data.token;  // Extract token from response

            // Store the token in localStorage and update the store
            localStorage.setItem('token', token);
            setUser(response.data.user);
            authenticated.value = true;
            router.push('/');  // Redirect after successful login
        } catch (error) {
            errorMessage.value = error.response ? error.response.data.message : 'Login failed. Please try again later.';
            console.error('Error during login:', errorMessage.value);
        }
    };

    // Logout the user
    const logout = async () => {
        try {
            await axiosClient.post('/logout');
            
            // Remove the token from localStorage
            localStorage.removeItem('token');
            setUser(null);
            authenticated.value = false;
            router.push('/login');  // Redirect to login after logout
        } catch (error) {
            console.error('Error during logout:', error);
        }
    };

    return {
        user,
        checkingAuth,
        authenticated,
        errorMessage,
        register,
        setUser,
        checkAuthStatus,
        login,
        logout
    };
});
