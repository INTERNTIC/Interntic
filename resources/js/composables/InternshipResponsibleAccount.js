import axios from "axios"
import { useRouter } from "vue-router"
import { ref } from "vue"
import shared from "@/shared"
export default function useInternshipResponsibleAccount() {
    const router = useRouter();
    const internshipResponsibleAccounts = ref([])
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')

    const axiosClient = axios.create({
        baseURL: '/api',
        headers: { 'auth-token': shared.token }
    });
    const restErrorsAndSuccess = () => {
        generalErrorMsg.value = '';
        generalSuccessMsg.value = '';
    }
    const handleError = (error) => {
        if (error.response.status == 422) {
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


    const getInternshipResponsibleAccounts = async () => {
        restErrorsAndSuccess()
        await axiosClient.get('/accountRequests').then((response) => {
            internshipResponsibleAccounts.value = response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const manageInternshipResponsibleAccount= async (decision, internship_request_id) => {
        restErrorsAndSuccess()
        await axiosClient.post('/accountRequests/manage/' + internship_request_id, decision).then((response) => {
            console.log(response);
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }

    



    return {
        getInternshipResponsibleAccounts,
        manageInternshipResponsibleAccount,
        
        internshipResponsibleAccounts,
        generalErrorMsg,
        generalSuccessMsg,
    }
}