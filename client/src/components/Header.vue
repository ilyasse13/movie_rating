<template>
     <header class="bg-stone-800 text-white p-4 shadow-md rounded-lg ">
      <div class="flex justify-between items-center mx-40">
        <!-- Logo or Title -->
        <div class="text-2xl font-semibold">My Application</div>
        <!-- Navigation (optional) -->
        <div class="space-x-4">
                <router-link 
                    v-for="link in links" 
                    :key="link.name" 
                    :to="link.path" 
                    class="text-white hover:text-gray-300"
                >
                    {{ link.name }}
                </router-link>
            </div>
            <div class="">userbar</div>
      </div>
    </header>
</template>
<script>
import { useAuthStore } from '@/stores/Auth';

export default {
    name: 'Header',
    setup() {
        const authStore = useAuthStore();
        const user = authStore.user;

        const logout = () => {
            authStore.logout();
        };

        // Sample navigation links inspired by Letterboxd
        const links = [
            { name: 'Films', path: '/films' },
            { name: 'Lists', path: '/lists' },
            { name: 'Members', path: '/members' },
           
        ];

        return {
            user,
            logout,
            links,
        };
    },
};
</script>
