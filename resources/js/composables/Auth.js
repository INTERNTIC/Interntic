import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import { useAuthStore } from '../stores/AuthStore';
import shared from "@/shared.js"
export default function useAuth() {
    const AuthStore = useAuthStore();
    const errors = ref({})
    const generalErrorMsg = ref('')
    const router = useRouter()

    const restErrorsAndSuccess = () => {
        errors.value = {}
        generalErrorMsg.value = '';
    }
    const handleError = (error) => {
        if (error.response.status == 422) {
            errors.value = error.response.data.errors;
            generalErrorMsg.value = error.response.data.message;
        } else if (error.response.status == 450) {
            generalErrorMsg.value = error.response.data.msg;
        } else if (error.response.status == 404) {
            generalErrorMsg.value = error.response.statusText;
            router.push({ name: "PageNotFound" })
        } else {
            generalErrorMsg.value = "Oppps !! Something went wrong";
        }
    }


    const login = async (guard, rememberMe, credentials) => {
        restErrorsAndSuccess()
        if (shared.guards.includes(guard)) {

            // console.log(JSON.parse(window.localStorage.getItem('authUser')));
            await axios.post('/login/' + guard, credentials).then((response) => {
                axios.defaults.headers.common['Authorization']=`Bearer ${response.data.data.token}`;
                AuthStore.$state.authUser = response.data.data;
                AuthStore.$state.userGuard = guard;
                AuthStore.$state.userToken = response.data.data.token;
                window.sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
                window.sessionStorage.setItem('token', response.data.data.token)
                window.sessionStorage.setItem('guard', guard)
                // AuthStore.setUserToken(response.data.data.token);
                if (rememberMe) {
                    window.localStorage.setItem('token', response.data.data.token)
                    window.localStorage.setItem('guard', guard)
                }
                router.push({ name: "statistiques" })
            }).catch((error) => {
                if (error.response) {
                    handleError(error)
                }
            })


        } else {
            console.log('guard fails');
            return
        }

    }
    // const checkUserToken = async (token) => {
    //     const config = {
    //         headers: {
    //             'auth-token': token,
    //         }
    //     }
    //     await axios.post('/loginWithToken/', {}, config).then((response) => {

    //         window.sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
    //         window.sessionStorage.setItem('token', response.data.data.token)
    //         return true;

    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //         return false;
    //     })
    // }
    const companySignUp = async (credentials) => {
        console.log(credentials);
    }
    const studentSignUp = async (credentials) => {
        console.log(credentials);
    }
    const logout = async () => {
        const config = {
            headers: {
                'auth-token': window.sessionStorage.getItem('token'),
            }
        }
        await axios.post('/logout', {}, config).then((response) => {
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }

        });
        window.sessionStorage.removeItem('authUser');
        window.sessionStorage.removeItem('token');
        window.localStorage.removeItem('authUser');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('hasCodeRunBefore');
        AuthStore.$state.authUser = null;
        AuthStore.$state.userGuard = null;
        AuthStore.$state.userToken = null;
    }
    return {
        login,
        
        companySignUp,
        studentSignUp,
        logout,
        generalErrorMsg,
        errors
    }
}