import { defineStore } from 'pinia';
import { guards } from "@/newShared";
const restErrorsAndSuccess = (STORE) => {
    STORE.authErrors = {}
    STORE.generalErrorMsg = '';
}
const handleError = (error, STORE) => {
    if (error.response.status == 422) {
        STORE.authErrors = error.response.data.errors;
        STORE.generalErrorMsg = error.response.data.message;
    } else if (error.response.status == 450) {
        STORE.generalErrorMsg = error.response.data.msg;
    } else if (error.response.status == 404) {
        STORE.generalErrorMsg = error.response.statusText;
        STORE.router.push({ name: "PageNotFound" })
    } else {
        STORE.generalErrorMsg = "Oppps !! Something went wrong";
    }
}
const setSessionStorage = (response) => {
    sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
    sessionStorage.setItem('token', response.data.data.token)
}
const setLocalStorage = (response) => {
    localStorage.setItem('token', response.data.data.token)
}
const setAuthenticated = (response, STORE) => {
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`;
    STORE.authUser = response.data.data;
    STORE.userGuard = response.data.data.guard;
    // save guard for next login
    localStorage.setItem('guard', response.data.data.guard);
}
export const useAuthStore = defineStore('auth', {

    state: () => ({
        authUser: null,
        userGuard: null,
        authErrors: [],
        generalErrorMsg: "",
    }),
    getters: {
        // getAuthUser: () => { return state.authUser }
    },
    actions: {
        // setAuthUser(user) { state.authUser = user },
        // setUserToken(newToken) { state.userToken = newToken },

        async login(guard, rememberMe, credentials) {
            restErrorsAndSuccess(this)
            if (guards.includes(guard)) {
                await axios.post('/login/' + guard, credentials).then((response) => {
                    // set Authenticated User
                    setAuthenticated(response, this)
                    setSessionStorage(response);
                    if (rememberMe) {
                        setLocalStorage(response);
                    }
                    this.router.push({ name: `statistiques` })
                }).catch((error) => {
                    if (error.response) {
                        handleError(error, this);
                    }
                })
            } else {
                // TODO redirect to student guard
                console.log('guard fails');
                this.router.push({ name: "login",params: {guard:"student"}})
                return
            }

        },
        async getUserByToken(token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            await axios.get('/getUserByToken/').then((response) => {
                // set Authenticated User
                setAuthenticated(response, this)
                setSessionStorage(response);
            }).catch((error) => {
                if (error.response) {
                    handleError(error, this);
                }
            })
        },
        async logout  () {
            await axios.post('/logout')
            sessionStorage.removeItem('authUser');
            sessionStorage.removeItem('token');
            localStorage.removeItem('authUser');
            localStorage.removeItem('token');
            this.authUser = null;
            this.userGuard = null;
            this.userToken = null;
            this.router.push({name:"login",params:{guard:localStorage.getItem("guard")}})
        }
    },
})