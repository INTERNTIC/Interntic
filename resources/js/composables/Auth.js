import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import { useAuthStore } from '../stores/AuthStore';
export default function useAuth() {
    const guards=['student','department','company','super_admin']
    const AuthStore = useAuthStore();
    const errors = ref({})
    const generalErrorMsg = ref('')
    const router = useRouter()
    const resetErrors=()=>{
        errors.value={};
        generalErrorMsg.value='';
    }
    const login = async (guard,rememberMe,credentials) => {
        resetErrors();
        if (guards.includes(guard)) {

        // console.log(JSON.parse(window.localStorage.getItem('authUser')));
        await axios.post('/api/login/'+guard, credentials).then((response) => {
            // console.log(response);
            AuthStore.$state.authUser = response.data.data;
            AuthStore.$state.userGuard = guard;
            AuthStore.$state.userToken=response.data.data.token;
            window.sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
            window.sessionStorage.setItem('token',response.data.data.token)
            window.sessionStorage.setItem('guard',guard)
            // AuthStore.setUserToken(response.data.data.token);
            router.push({ name: "dashboard" })
        }).catch((error) => {
            generalErrorMsg.value="An Error Happend"
            if(error.response.status==422){
                console.log(error.response);
            }else if(error.response.status==450) {
                generalErrorMsg.value= error.response.data.msg
            }else{
                console.log(error);
            }
            // if (error.response) {
            //     errors.value = error.response.data.errors;
            //     generalErrorMsg.value = error.response.data.generalErrorMsg;
            // }
        })

       
        }else{
            console.log('guard fails');
            return
        }
        // console.log(guard);
        // console.log(JSON.parse(JSON.stringify(credentials)));
        // console.log(rememberMe);
        // AuthStore.$state.authUser=credentials;
        if(rememberMe){
            window.localStorage.setItem('user', JSON.stringify(credentials))
        }
        
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