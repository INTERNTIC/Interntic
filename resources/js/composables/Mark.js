import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import shared from "@/shared"
export default function useInternship() {
    const router = useRouter();
    const studentMarks = ref([])
    const errors = ref({})
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')


    const restErrorsAndSuccess = () => {
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

  
    const getStudentMarks = async () => {
        restErrorsAndSuccess()
        await axios.get('/marks').then((response) => {
            studentMarks.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    
    const storeMark = async (mark) => {
        restErrorsAndSuccess()
        await axios.post('/marks', mark).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const updateMark = async (id,mark) => {
        restErrorsAndSuccess()
        await axios.patch('/marks/'+id, mark).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const destroyMark = async (id) => {
        restErrorsAndSuccess()
        await axios.delete('/marks/'+id).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    return {
        getStudentMarks,
        storeMark,
        updateMark,
        destroyMark,

        studentMarks,
        generalErrorMsg,
        generalSuccessMsg,
        errors
    }
}