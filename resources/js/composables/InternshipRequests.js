import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
export default function useInternshipRequest() {
    const newCause = ref({
        id: null,
        cause: ""
    });
    const router = useRouter();
    const studentsRequests = ref([])
    const departmentRefuseCauses = ref([])
    const companyRefuseCauses = ref([])
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


    const getStudentsRequests = async () => {
        restErrorsAndSuccess()
        await axios.get('/internshipRequests').then((response) => {
            studentsRequests.value = response.data.data
        }).catch((error) => {

            if (error.response) {
                handleError(error)
            }
        })
    }
     const getStudentInternships = async () => {
        restErrorsAndSuccess()
        await axios.get('/internships/students').then((response) => {
            studentsRequests.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getDepartmentRefuseCauses = async () => {
        restErrorsAndSuccess()
        await axios.get('/departmentCauses').then((response) => {
            departmentRefuseCauses.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const getCompanyRefuseCauses = async () => {
        restErrorsAndSuccess()
        await axios.get('/companyCauses').then((response) => {
            companyRefuseCauses.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const manageInternshipRequests = async (decision, internship_request_id) => {
        restErrorsAndSuccess()
        await axios.post('/internshipRequests/manage/' + internship_request_id, decision).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }

    const storeDepartmentRefuseCause = async (cause) => {
        restErrorsAndSuccess()
        await axios.post('/departmentCauses', cause).then((response) => {
            newCause.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const storeCompanyRefuseCause = async (cause) => {
        restErrorsAndSuccess()
        await axios.post('/companyCauses', cause).then((response) => {
            newCause.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }



    return {
        getStudentsRequests,
        getDepartmentRefuseCauses,
        getCompanyRefuseCauses,
        manageInternshipRequests,
        storeDepartmentRefuseCause,
        storeCompanyRefuseCause,
        getStudentInternships,

        departmentRefuseCauses,
        companyRefuseCauses,
        newCause,
        studentsRequests,
        generalErrorMsg,
        generalSuccessMsg,
        errors
    }
}