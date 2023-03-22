import { createApp } from 'vue';
import './style.css';
// @ts-ignore
import App from './App.vue';
import { router } from '../router/routes';
import axios from 'axios';
import VueAxios from "vue-axios";
import { createPinia } from 'pinia';

import Navigation from './components/Navigation.vue';
import LinkedButton from './components/elements/LinkedButton.vue';

const pinia = createPinia();

createApp(App)
    .use(pinia)
    .use(router)
    .use(VueAxios, axios)
    .component('Navigation', Navigation)
    .component('LinkedButton', LinkedButton)
    .mount('#app');