import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {createVuetify} from "vuetify";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const app = createApp(App)

const vuetify = createVuetify({
    components,
    directives,
})

app.use(router)

createApp(App).use(vuetify).mount('#app')
