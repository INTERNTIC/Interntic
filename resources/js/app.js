import './bootstrap';
import { createApp } from "vue";
import Global from "./pages/Global.vue";
import router from "./router";
import { createPinia } from 'pinia'
// import VueMeta from 'vue-meta'


// import "./assets/css/vendor/jquery-jvectormap-1.2.2.css";

// import "./assets/css/app.min.css";



// import"./assets/js/vendor.min.js";
// import"./assets/js/app.min.js";

// import"./assets/js/vendor/apexcharts.min.js";
// import"./assets/js/vendor/jquery-jvectormap-1.2.2.min.js";
// import"./assets/js/vendor/jquery-jvectormap-world-mill-en.js";
// import"./assets/js/pages/demo.dashboard.js";

const app = createApp(Global);
const pinia = createPinia();
// app.use(VueMeta)
// app.use(VueHead);
app.use(router);
app.use(pinia);

app.mount("#app");
