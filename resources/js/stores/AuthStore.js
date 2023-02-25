import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({ authUser: null, userToken: null }),
    getters: {
        // getAuthUser: () => { return state.authUser }
    },
    actions: {
        setAuthUser(user) { state.authUser = user },
        setUserToken(newToken) { state.userToken = newToken }
    },
})