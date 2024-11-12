<template>
  <div>
    <!-- Header Bar -->
    <Header/>

    <!-- Main Content Area -->
    <div class="flex-1 p-8">
      <router-view></router-view> <!-- This will render the dynamic route content -->
    </div>
  </div>
</template>
  
  <script>
  import Header from '@/components/Header.vue';

 
  
  export default {
    name: 'Home',
    components: {
    Header, // Register the Header component
  },
  };
  </script>
  
  <style scoped>
  /* Scoped styles for Home.vue */
  </style>
  