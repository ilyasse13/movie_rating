<template>
    <div class="flex justify-center items-center min-h-screen ">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-semibold text-center mb-6">Register</h2>
  
        <form @submit.prevent="handleRegister">
          <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input 
              v-model="formData.name" 
              type="text" 
              id="name" 
              placeholder="Enter your name" 
              class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input 
              v-model="formData.email" 
              type="email" 
              id="email" 
              placeholder="Enter your email" 
              class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input 
              v-model="formData.password" 
              type="password" 
              id="password" 
              placeholder="Enter your password" 
              class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <button 
            type="submit" 
            :disabled="loading" 
            class="w-full p-2 mt-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:bg-blue-300 transition"
          >
            Register
          </button>
  
          <!-- Show error message if there's any -->
          <div v-if="errorMessage" class="mt-4 text-red-500 text-center">
            {{ errorMessage }}
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useAuthStore } from '../stores/Auth'
  
  export default {
    setup() {
      const authStore = useAuthStore();
      const formData = ref({
        name: '',
        email: '',
        password: '',
      });
      const loading = ref(false);
  
      // Call the register function from the store
      const handleRegister = async () => {
        loading.value = true;
        try {
          const data = await authStore.register(formData.value);
          if (data) {
            // You can redirect the user to the login page or dashboard after successful registration
            console.log('Registration successful:', data.message);
          } else {
            // Show the error message if registration fails
            console.log('Registration failed');
          }
        } catch (error) {
          console.error('Error during registration:', error);
        } finally {
          loading.value = false;
        }
      };
  
      return {
        formData,
        handleRegister,
        loading,
        errorMessage: authStore.errorMessage, // Get the error message from the store
      };
    },
  };
  </script>
  
  <style scoped>
  /* You can add any custom styles if necessary */
  </style>
  