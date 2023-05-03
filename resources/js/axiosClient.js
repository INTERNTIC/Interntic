import axios from "axios";
import { ref } from "vue";
import router from "./router";

export const errors = ref({})
export const generalErrorMsg = ref('')
export const generalSuccessMsg = ref('')


export const restErrorsAndSuccess = () => {
    errors.value = {}
    generalErrorMsg.value = '';
    generalSuccessMsg.value = '';
}
export const handleError = (error) => {
    if (error.response.status == 422) {
        errors.value = error.response.data.errors;
        generalErrorMsg.value = error.response.data.message;
    } else if (error.response.status == 450) {
        generalErrorMsg.value = error.response.data.msg;
    } else if (error.response.status == 404) {
        generalErrorMsg.value = error.response.statusText;
        router.push({ name: "PageNotFound" })
        
    } else if (error.response.status == 403) {
        console.log('unaithrized');
        // router.push({ name: "PageNotFound" })
    } else if (error.response.status == 401) {
        console.log('unAuth');
        // router.push({ name: "login",params:{guard:localStorage.getItem("guard")} })
    } else {

        generalErrorMsg.value = "Oppps !! Something went wrong";
    }
}


axios.defaults.baseURL = "/api";
const token = sessionStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
axios.interceptors.request.use(
    config => {
        // Reset the variable before every request
        restErrorsAndSuccess()
        return config;
    },
);
axios.interceptors.response.use(
    response => {
        // Do something with the response data
        generalSuccessMsg.value = response.data.msg
        return response;
    },
    error => {
        if (error.response) {
            handleError(error)
        }
        return error;
        // return Promise.reject(error)
    },
);
