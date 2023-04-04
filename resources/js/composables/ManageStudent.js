import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import shared from "@/shared"
export default function useStudent() {
    const router = useRouter();
    const students = ref([])
    const errors = ref({})
    const editErrors = ref({})
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')
    const levels = ref([])
    const majors = ref([])
    const axiosClient = axios.create({
        baseURL: '/api',
        headers: { 'auth-token': shared.token }
    });
    const restErrorsAndSuccess = () => {
        editErrors.value = {}
        errors.value = {}
        generalErrorMsg.value = '';
        generalSuccessMsg.value = '';
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
    const storeStudent = async (credentials) => {
        restErrorsAndSuccess()
        await axiosClient.post('/addStudentInfo', credentials).then((response) => {
            generalSuccessMsg.value = response.data.msg

        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }

    const updateStudent = async (student) => {
        restErrorsAndSuccess()
        await axiosClient.patch('/editStudentInfo/' + student.id, student).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getStudents = async () => {
        restErrorsAndSuccess()
        await axiosClient.get('/displayStudents').then((response) => {
            students.value = response.data.data
            errors.value = {}
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getMajorsOfLevel = async (id) => {
        restErrorsAndSuccess()
        await axiosClient.get('/levels/majors/' + id).then((response) => {
            majors.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getLevels = async () => {
        restErrorsAndSuccess()
        await axiosClient.get('/levels').then((response) => {
            levels.value = response.data.data

        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const destroyStudent = async (student_id) => {
        restErrorsAndSuccess()
        await axiosClient.delete('/deleteStudent/' + student_id).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    return {
        getStudents,
        storeStudent,
        getMajorsOfLevel,
        getLevels,
        destroyStudent,
        updateStudent,

        students,
        levels,
        majors,
        generalErrorMsg,
        generalSuccessMsg,
        editErrors,
        errors
    }
}