
import { guards } from "@/newShared";
import { useAuthStore } from '@/stores/AuthStore';
import router from "../router";

const setSessionStorage = (response) => {
    sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
    sessionStorage.setItem('token', response.data.data.token)
}
const setLocalStorage = (response) => {
    localStorage.setItem('token', response.data.data.token)
}
const setAuthenticated = (response) => {
    const authStore = useAuthStore();

    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`;
    const user = response.data.data;
    const guard = response.data.data.guard;
    authStore.authUser = user;
    authStore.userGuard = guard;
    switch (guard) {
        case "student":
            authStore.is_student = true;
            break;
        case "internship_responsible":
            authStore.is_internship_responsible = true;
            break;
        case "department_head":
            authStore.is_department_head = true;
            break;
    }
    // save guard for next login
    localStorage.setItem('guard', response.data.data.guard);
}
export default () => {


    const login = async (guard, rememberMe, credentials) => {
        if (guards.includes(guard)) {

            await axios.post('/login/' + guard, credentials).then((response) => {
                setAuthenticated(response);
                setSessionStorage(response);
                if (rememberMe) {
                    setLocalStorage(response)
                }
                router.push("statistiques")
            }).catch((error) => {

            })
        } else {
            // TODO redirect to student guard
            const guard = localStorage.getItem("guard") ?? "student"
            router.push({ name: "login", params: { guard: guard } })

        }

    }
    const getUserByToken = async (token) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        await axios.get('/getUserByToken/').then(response => {
            if (!response.data.data) {
                logout()
            } else {
                // set Authenticated User
                setAuthenticated(response)
                setSessionStorage(response);
            }

        })

    }
    const logout = async () => {
        await axios.post('/logout')
        const authStore = useAuthStore();
        sessionStorage.removeItem('authUser');
        sessionStorage.removeItem('token');
        localStorage.removeItem('authUser');
        localStorage.removeItem('token');
        authStore.authUser = null;
        authStore.userGuard = null;
        window.location.replace("/login/" + localStorage.getItem("guard"));
        // router.push({ name: "login", params: { guard: localStorage.getItem("guard") } })
    }
    const resetPassword = async (passwordCredentials) => {
        await axios.patch('/resetPassword', passwordCredentials)
    }
    const updatePassword = async (passwordCredentials) => {
        await axios.patch('/update-password', passwordCredentials)
    }

    return {
        login,
        logout,
        getUserByToken,
        resetPassword,
        updatePassword,
    }
}