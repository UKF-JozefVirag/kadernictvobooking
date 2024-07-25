import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/api', // Použite 'https://' iba ak máte správne nastavený HTTPS server
    withCredentials: true, // Ak potrebujete zahrnúť cookies pre cross-site requests
    xsrfCookieName: 'XSRF-TOKEN', // Prispôsobte podľa vášho backendu
    xsrfHeaderName: 'X-XSRF-TOKEN', // Prispôsobte podľa vášho backendu
    headers: {
        'Content-Type': 'application/json'
    }
});

export default axiosInstance;
