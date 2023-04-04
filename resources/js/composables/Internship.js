import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import shared from "@/shared"
export default function useInternship() {
    const router = useRouter();
    const studentInternships = ref([])
    const errors = ref({})
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')

    const axiosClient = axios.create({
        baseURL: '/api',
        headers: { 'auth-token': shared.token }
    });
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


    const getStudentInternships = async () => {
        restErrorsAndSuccess()
        await axiosClient.get('/internships/assess').then((response) => {
            studentInternships.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    // const getDepartmentRefuseCauses = async () => {
    //     restErrorsAndSuccess()
    //     await axiosClient.get('/departmentCauses').then((response) => {
    //         departmentRefuseCauses.value = response.data.data
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }
    // const getCompanyRefuseCauses = async () => {
    //     restErrorsAndSuccess()
    //     await axiosClient.get('/companyCauses').then((response) => {
    //         companyRefuseCauses.value = response.data.data
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }
    // const manageInternshipRequests = async (decision, internship_request_id) => {
    //     restErrorsAndSuccess()
    //     await axiosClient.post('/internshipRequests/manage/' + internship_request_id, decision).then((response) => {
    //         generalSuccessMsg.value = response.data.msg
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }

    // const storeDepartmentRefuseCause = async (cause) => {
    //     restErrorsAndSuccess()
    //     await axiosClient.post('/departmentCauses', cause).then((response) => {
    //         newCause.value = response.data.data
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }
    // const storeCompanyRefuseCause = async (cause) => {
    //     restErrorsAndSuccess()
    //     await axiosClient.post('/companyCauses', cause).then((response) => {
    //         newCause.value = response.data.data
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }



    return {
        getStudentInternships,

        
        studentInternships,
        generalErrorMsg,
        generalSuccessMsg,
        errors
    }
}