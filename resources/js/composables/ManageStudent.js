import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
export default function useAuth() {
    const errors = ref({})
    const generalErrorMsg = ref('')
    const router = useRouter()
    const levels=ref([{
        name: "lokman2",
        id: '2'
    }, {
        name: "lokman1",
        id: '1'
    }])
    const majors=ref([{
        name: "lokman2",
        id: '2'
    }, {
        name: "lokman1",
        id: '1'
    }])
    const addStudent = async (credentials) => {
        console.log(JSON.parse(JSON.stringify(credentials)));
        // await axios.post('/api/login', credentials).then((response) => {
        //     AuthStore.$state.authUser = response.data.data
        //     // AuthStore.setUserToken(response.data.data.teken)
        //     errors.value = {}
        //     router.push({ name: "dashboard" })
        // }).catch((error) => {
        //     if (error.response) {
        //         errors.value = error.response.data.errors;
        //         msg.value = error.response.data.msg;
        //     }
        // })
    }
    const getMajors = async () => {
    }
    const getLevels = async () => {
    }
    
    return {
        addStudent,
        getMajors,
        levels,
        majors,
        generalErrorMsg,
        errors
    }
}