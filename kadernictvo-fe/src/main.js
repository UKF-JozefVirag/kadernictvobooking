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

import { createI18n } from 'vue-i18n';

import en from './assets/locales/en.json';
import sk from './assets/locales/sk.json';

const i18n = createI18n({
    locale: 'sk',
    fallbackLocale: 'sk',
    messages: {
        en,
        sk
    }
});


const app = createApp(App)

const vuetify = createVuetify({
    components,
    directives,
})

createApp(App).use(vuetify).use(i18n).use(router).use(BootstrapIconsPlugin).mount('#app')
