import { useRouter } from "vue-router"
import { ref } from "vue"
import shared from "@/shared"
export default function useInternship() {
    const router = useRouter();
    const studentInternshipsNotAssessed = ref([])
    const studentInternships = ref([])
    const assessments = ref([])
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


    const getStudentInternshipsNotAssessed = async () => {
        restErrorsAndSuccess()
        await axios.get('/internships/students/not-assessed').then((response) => {
            studentInternshipsNotAssessed.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getAssessment = async () => {
        restErrorsAndSuccess()
        await axios.get('/assessments').then((response) => {
            assessments.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const storeAssessment = async (assessment) => {
        restErrorsAndSuccess()
        await axios.post('/assessments', assessment).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const updateAssessment = async (id,assessment) => {
        restErrorsAndSuccess()
        await axios.patch('/assessments/'+id, assessment).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const destroyAssessment = async (id) => {
        restErrorsAndSuccess()
        await axios.delete('/assessments/'+id).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    return {
        getStudentInternshipsNotAssessed,
        getStudentInternships,
        getAssessment,
        storeAssessment,
        updateAssessment,
        destroyAssessment,

        assessments,
        studentInternshipsNotAssessed,
        studentInternships,
        generalErrorMsg,
        generalSuccessMsg,
        errors
    }
}