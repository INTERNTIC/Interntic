import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
export default function useAuth() {
    const students=ref([])
    const errors = ref({})
    const editErrors = ref({})
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')
    const router = useRouter()
    const levels=ref([])
    const majors=ref([])
    const addStudent = async (credentials) => {
        // console.log(JSON.parse(JSON.stringify(credentials)));
        await axios.post('/api/addStudentInfo', credentials).then((response) => {
            errors.value = {}
            generalSuccessMsg.value=response.data.msg
        }).catch((error) => {
            if (error.response) {
                errors.value = error.response.data.errors;
                generalErrorMsg.value = error.response.data.msg;
            }
        })
    }
    const getStudent = async (id) => {
        console.log(id);
        // await axios.post('/api/login', credentials).then((response) => {
        //     AuthStore.$state.authUser = response.data.data
        //     // AuthStore.setUserToken(response.data.data.teken)
        //     errors.value = {}
        //     router.push({ name: "dashboard" })
        // }).catch((error) => {
        //     if (error.response) {
        //         errors.value = error.response.data.errors;
        //         generalErrorMsg.value = error.response.data.msg;
        //     }
        // })
    }
    const deleteStudent = async (student) => {
        console.log('delete',JSON.parse(JSON.stringify(student)));
    }
    const editStudent = async (student) => {
        console.log('edit',JSON.parse(JSON.stringify(student)));
    }
    const getStudents = async () => {
    }
    const getMajorsOfLevel = async (id) => {
         await axios.get('/api/levels/majors/'+id).then((response) => {
            errors.value = {}
            majors.value = response.data.data
            
        }).catch((error) => {
            if (error.response) {
                errors.value = error.response.data.errors;
                generalErrorMsg.value = error.response.data.msg;
            }
        })
    }
    const getLevels = async () => {
        await axios.get('/api/levels').then((response) => {
            errors.value = {}
            levels.value = response.data.data
            
        }).catch((error) => {
            if (error.response) {
                errors.value = error.response.data.errors;
                generalErrorMsg.value = error.response.data.msg;
            }
        })
    }
    return {
        addStudent,
        getMajorsOfLevel,
        getLevels,
        deleteStudent,
        editStudent,
        students,
        levels,
        majors,
        generalErrorMsg,
        generalSuccessMsg,
        editErrors,
        errors
    }
}