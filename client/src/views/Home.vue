<template>
  <div>
    <!-- Header Bar -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
      <div class="flex justify-between items-center">
        <!-- Logo or Title -->
        <div class="text-2xl font-semibold">My Application</div>
        
        <!-- Navigation (optional) -->
        <div class="space-x-4">
          <router-link to="/home" class="text-white hover:text-gray-300">Home</router-link>
          <router-link to="/profile" class="text-white hover:text-gray-300">Profile</router-link>
          <router-link to="/settings" class="text-white hover:text-gray-300">Settings</router-link>
        </div>
        
        <!-- User Info / Logout Button -->
        <div>
          <button
            v-if="user"
            @click="logout"
            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200"
          >
            Logout
          </button>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <div class="flex-1 p-8">
      <router-view></router-view> <!-- This will render the dynamic route content -->
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
  