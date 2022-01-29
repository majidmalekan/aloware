import axios from 'axios';


const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/v1',
    timeout: 5000,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    }
});

instance.interceptors.request.use(function (config) {

    return config;
}, function (err) {
    return Promise.reject(err)
});

instance.interceptors.response.use(function (response) {
    return response.data;
}, function (error) {
    return Promise.reject(error.response);
});


export default instance;
