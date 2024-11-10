<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-md">
            <h1 class="text-3xl font-bold text-blue-600 mb-4">Verify Your Email</h1>
            <p class="text-gray-700 mb-6">
                Please check your inbox for the verification email. Enter the code below to verify your email address.
            </p>

            <!-- Verification Code Form -->
            <div>
                <input v-model="verificationCode" type="text" placeholder="Enter Verification Code"
                    class="border border-gray-300 p-2 rounded-lg w-full mb-4" maxlength="6" @input="validateCode" />
                <button @click="verifyEmail" :disabled="isSubmitting || !isCodeValid"
                    class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 w-full">
                    <span v-if="isSubmitting">Verifying...</span>
                    <span v-else>Verify Email</span>
                </button>
                <p v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</p>
                <p v-if="successMessage" class="text-green-500 mt-2">{{ successMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axiosClient from '@/api/axios';
import { useAuthStore } from '../stores/Auth';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'VerifyEmail',
    setup() {
        const verificationCode = ref('');
        const errorMessage = ref('');
        const successMessage = ref('');
        const isSubmitting = ref(false);
        const isCodeValid = ref(false);
        const router = useRouter();
        const authStore = useAuthStore();

        // Function to validate the code
        const validateCode = () => {
            isCodeValid.value = /^[0-9]{6}$/.test(verificationCode.value); // Check if the code is exactly 6 digits
        };

        // Function to verify the email
        const verifyEmail = async () => {
    // Check if verification code is entered
    if (!verificationCode.value) {
        errorMessage.value = 'Please enter the verification code.';
        return;
    }

    isSubmitting.value = true;
    errorMessage.value = ''; // Clear any previous error
    successMessage.value = ''; // Clear any previous success message

    try {
        // Send the verification code to the server
        const response = await axiosClient.post('/verify-email', {
            verification_code: verificationCode.value,
        });

        // Store the token if present in response
        const token = response.data.token;
        if (token) {
            localStorage.setItem('token', token); // Save token in localStorage
            axiosClient.defaults.headers.common['Authorization'] = `Bearer ${token}`; // Set token for future requests
        }

        // Update the user data in the auth store and mark as authenticated
        authStore.setUser(response.data.user);
        authStore.authenticated = true;
        
        // Clear the verification code input and show success message
        verificationCode.value = '';
        successMessage.value = 'Your email has been successfully verified!';

        // Redirect after a slight delay to provide feedback
        setTimeout(() => {
            router.push('/'); // Navigate to home or desired page
        }, 900);

    } catch (error) {
        // Set error message based on server response or generic error
        errorMessage.value = error.response ? error.response.data.message : 'An error occurred. Please try again later.';
        console.error('Verification error:', error);
    } finally {
        isSubmitting.value = false; // Reset submitting state
    }
};



        return {
            verificationCode,
            errorMessage,
            successMessage,
            isSubmitting,
            isCodeValid,
            verifyEmail,
            validateCode
        };
    },
};
</script>

<style scoped>
/* Add any scoped styles for the verification page here */
</style>