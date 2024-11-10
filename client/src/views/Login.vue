<template>
    <div class="flex items-center justify-center min-h-screen">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-semibold text-center text-blue-600 mb-6">Login</h2>
        <form @submit.prevent="handleLogin">
          <!-- Email Input -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="email"
              type="email"
              id="email"
              placeholder="Enter your email"
              class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <!-- Password Input -->
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              v-model="password"
              type="password"
              id="password"
              placeholder="Enter your password"
              class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <!-- Submit Button -->
          <button
            type="submit"
            class="w-full py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
          >
            Login
          </button>
  
          <!-- Error Message -->
          <p v-if="errorMessage" class="mt-4 text-sm text-red-500 text-center">{{ errorMessage }}</p>
        </form>
  
        <div class="mt-6 text-center">
          <p class="text-sm text-gray-600">
            Don't have an account?
            <router-link to="/register" class="text-blue-600 hover:text-blue-800">Register</router-link>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useAuthStore } from '@/stores/Auth'
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  export default {
    name: 'LoginPage',
    setup() {
      const email = ref('')
      const password = ref('')
      const authStore = useAuthStore()
      const router = useRouter() // Vue Router for navigation
      const errorMessage = ref('')
  
      const handleLogin = async () => {
        const credentials = { email: email.value, password: password.value }
  
        try {
          const result = await authStore.login(credentials)
          if (result) {
            router.push('/') // Redirect to dashboard after login
          }
        } catch (error) {
          errorMessage.value = authStore.errorMessage // Display error message from the store
        }
      }
  
      return {
        email,
        password,
        errorMessage,
        handleLogin
      }
    }
  }
  </script>
  
  <style scoped>
  /* Optional custom styles can go here */
  </style>
  