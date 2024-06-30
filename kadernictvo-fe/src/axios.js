import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: 'https://localhost:8000/api',
    withXSRFToken: true,
    withCredentials: true,
});

export default axiosInstance;
