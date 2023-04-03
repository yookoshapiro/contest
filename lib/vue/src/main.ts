import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import { router } from './lib/router/routes';
import axios from 'axios';
import VueAxios from "vue-axios";
import { createPinia } from 'pinia';

createApp(App)
    .use(router)
    .use(createPinia())
    .use(VueAxios, axios)
    .mount('#app');