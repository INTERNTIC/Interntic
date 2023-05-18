import { defineStore } from 'pinia';


export const useAuthStore = defineStore('auth', {

    state: () => ({
        authUser: null,
        userGuard: null,
        is_student: false,
        is_internship_responsible: false,
        is_department_head: false,
    }),
    getters: {
    },
    actions: {
  
    },
})