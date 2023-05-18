
import { ref } from "vue"

export default ()=> {

    const internshipResponsibleAccounts = ref([])

    const getInternshipResponsibleAccounts = async () => {
        
        await axios.get('/accountRequests').then((response) => {
            internshipResponsibleAccounts.value = response.data.data
        })
    }
    const manageInternshipResponsibleAccount= async (decision, internship_request_id) => {
        
        await axios.post('/accountRequests/manage/' + internship_request_id, decision)
    }

    return {
        getInternshipResponsibleAccounts,
        manageInternshipResponsibleAccount,
        
        internshipResponsibleAccounts,
    }
}