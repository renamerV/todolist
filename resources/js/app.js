import { createApp } from "vue";
import App from "./components/App.vue";

import 'bootstrap/dist/js/bootstrap.bundle.js';
import 'bootstrap/dist/css/bootstrap.min.css';

require('./bootstrap');
const app = createApp(App)

app.mount("#app");

