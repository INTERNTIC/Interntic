import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import { useAuthStore } from '../stores/AuthStore';
export default function useAuth() {
    const AuthStore = useAuthStore();
    const errors = ref({})
    const generalErrorMsg = ref('')
    const router = useRouter()
    const login = async (guard,rememberMe,credentials) => {
        if(guard=='department'){

        }else if(guard=='company'){

        }else if(guard=='student'){

        }else if(guard=='admin'){

        }else{
            return
        }
        console.log(guard);
        console.log(JSON.parse(JSON.stringify(credentials)));
        console.log(rememberMe);
        AuthStore.$state.authUser=credentials;
        if(rememberMe){
            window.localStorage.setItem('user', JSON.stringify(credentials))
        }
        console.log(JSON.parse(window.localStorage.getItem('authUser')));
        // await axios.post('/api/login', credentials).then((response) => {
        //     AuthStore.$state.authUser = response.data.data
        //     // AuthStore.setUserToken(response.data.data.teken)
        //     errors.value = {}
        //     router.push({ name: "dashboard" })
        // }).catch((error) => {
        //     if (error.response) {
        //         errors.value = error.response.data.errors;
        //         generalErrorMsg.value = error.response.data.generalErrorMsg;
        //     }
        // })
    }
    const companySignUp = async (credentials) => {
        console.log(credentials);
    }
    const departmentSignUp = async (credentials) => {
        console.log(credentials);
    }
    const studentSignUp = async (credentials) => {
        console.log(credentials);
    }
    const logout =()=>{
        window.localStorage.removeItem('authUser');
    }
    return {
        login,
        companySignUp,
        departmentSignUp,
        studentSignUp,
        logout,
        generalErrorMsg,
        errors
    }
}