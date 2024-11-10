import axios from "axios";

// Create an Axios instance
const axiosClient = axios.create({
    baseURL: 'http://localhost:8000/api', // Replace with your API base URL
    headers: {
        'Content-Type': 'application/json',
    },
    withCredentials: true // Enable credentials (cookies) to be sent with requests
});

// Add a request interceptor to set the Authorization header
axiosClient.interceptors.request.use(config => {
    // Get the token from local storage
    const token = localStorage.getItem('token');

    // If a token is found, set it as the Authorization header
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }

    return config;
}, error => {
    // Handle request error
    return Promise.reject(error);
});

export default axiosClient;
