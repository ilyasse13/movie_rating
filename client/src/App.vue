<template>
  <div class=' overflow-x-hidden text-neutral-300 antialiased '>
    <div class="fixed top-0 -z-10 h-full w-full">
      <div class="relative size-full bg-black">
        <div
          class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px]">
        </div>
        <div
          class="absolute inset-x-0 top-[-10%] size-[1000px] rounded-full bg-[radial-gradient(circle_400px_at_50%_300px,#fbfbfb36,#000)]">
        </div>
      </div>
    </div>
    <!-- Loading Spinner -->
    <div v-if="authStore.checkingAuth"
      class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
      <div class="loader"></div> <!-- A custom loading spinner -->
    </div>

    <!-- Main Content -->
    <main v-else class="flex-grow container mx-auto ">
      <router-view />
    </main>
  </div>
</template>

<script>
import { onMounted } from 'vue';
import { useAuthStore } from './stores/Auth'; // Adjust path to your auth store
import { ref } from 'vue';

export default {
  name: 'App',
  setup() {
    const authStore = useAuthStore();
    const checkingAuth = authStore.checkingAuth;

    // Check authentication status on page load
    // onMounted(async () => {
    //   await checkAuthStatus();
    // });

    // // Authentication check logic
    // const checkAuthStatus = async () => {
    //   try {
    //     await authStore.checkAuthStatus();
    //   } catch (error) {
    //     console.error('Error checking auth status:', error);
    //   }
    // };

    return {
      authStore,
      checkingAuth
    };
  },
};
</script>

<style scoped>
/* Loading Spinner Styles */
.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #dba334;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
