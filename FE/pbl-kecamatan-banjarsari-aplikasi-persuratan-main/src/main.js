// main.js

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ToastPlugin from 'vue-toast-notification';
import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsExample from '@/components/DocsExample'

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import 'vue-toast-notification/dist/theme-bootstrap.css';

import axios from 'axios';

const app = createApp(App)
axios.defaults.baseURL = 'http://127.0.0.1:8000/';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/', 
  timeout: 5000, 
});

const api = axios.create()

// Interceptor for requests
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Interceptor for responses
api.interceptors.response.use(response => {
  return response;
}, error => {
  if (error.response && error.response.status === 404) {
    return Promise.reject(null);
  }
  return Promise.reject(error);
});

export default api;


app.config.globalProperties.$axios = axiosInstance;

app.use(store)
app.use(router)
app.use(CoreuiVue)
app.use(ToastPlugin);
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.component('DocsExample', DocsExample)

app.mount('#app')
