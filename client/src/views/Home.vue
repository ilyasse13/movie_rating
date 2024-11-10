<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-md">
        <h1 class="text-3xl font-bold text-blue-600 mb-4">Welcome to the Home Page!</h1>
        <p class="text-gray-700 mb-6">
          This is a protected page. Only logged-in users can access this content.
        </p>
  
        <!-- User data section -->
        <div v-if="user" class="mb-4">
          <p class="text-gray-900 font-semibold">Hello, {{ user.name }}!</p>
          <p class="text-gray-600">Email: {{ user.email }}</p>
          <p class="text-gray-600">Joined on: {{ new Date(user.created_at).toLocaleDateString() }}</p>
        </div>
        
       
        <button
          v-if="user"
          @click="logout"
          class="mt-4 bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200"
        >
          Logout
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import { useAuthStore } from '@/stores/Auth';

 
  
  export default {
    name: 'Home',
    setup() {
      const authStore = useAuthStore();
      const user =  authStore.user;
  
      
  
      const logout = () => {
        authStore.logout();
      };
  
      return {
        user,
        logout,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Scoped styles for Home.vue */
  </style>
  