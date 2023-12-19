import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import { router } from './lib/router/routes';
import axios from 'axios';
import VueAxios from "vue-axios";
import { createPinia } from 'pinia';

import Elements from './components/elements';

createApp(App)
    .use(router)
    .use(createPinia())
    .use(VueAxios, axios)
    .component('Alert', Elements.Alert)
    .component('CustomAlert', Elements.CustomAlert)
    .component('Icon', Elements.Icon)
    .component('LinkedButton', Elements.LinkedButton)
    .component('Notifications', Elements.Notifications)
    .component('SimpleButton', Elements.SimpleButton)
    .component('InputText', Elements.InputText)
    .mount('#app');