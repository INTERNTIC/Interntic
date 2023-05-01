import './bootstrap';
import { createApp, markRaw } from "vue";
import Global from "./pages/Global.vue";
import router from "./router";
import { createPinia } from 'pinia'
import Notifications from '@kyvg/vue3-notification'
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import "./axiosClient";



const app = createApp(Global);
const pinia = createPinia();
pinia.use(({ store }) => {
    store.router = markRaw(router);
})

app.use(pinia);
app.use(LoadingPlugin);
app.use(Notifications);
app.use(router);
app.mount("#app");

