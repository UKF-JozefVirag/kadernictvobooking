import './assets/styles/main.scss';
import './assets/styles/buttons.scss';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import {createVuetify} from "vuetify";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import {
    BootstrapIconsPlugin
} from "bootstrap-icons-vue";

const app = createApp(App)

const vuetify = createVuetify({
    components,
    directives,
})

createApp(App).use(vuetify).use(router).use(BootstrapIconsPlugin).mount('#app')
