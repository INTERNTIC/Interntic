import './bootstrap';
import { createApp, markRaw } from "vue";
import Global from "./pages/Global.vue";
import router from "./router";
import { createPinia } from 'pinia'
import Notifications from '@kyvg/vue3-notification'
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import CKEditor from '@ckeditor/ckeditor5-vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import "./axiosClient";



const app = createApp(Global);
const pinia = createPinia();
pinia.use(({ store }) => {
    store.router = markRaw(router);
})

app.config.errorHandler = (error, vm, info) => {
    // Handle the error here
    console.log('An error occurred:', error);
    console.log('Component:', vm);
    console.log('Error info:', info);
  };
app.component('FullWidthModal', FullWidthModal);
app.component('CustomInput', CustomInput);
app.use(pinia);
app.use(CKEditor)
app.use(LoadingPlugin);
app.use(Notifications);
app.use(router);
app.mount("#app");

