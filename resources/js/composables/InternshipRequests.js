import { ref } from "vue"
export default function useInternshipRequest() {
    const newCause = ref({
        id: null,
        cause: ""
    });
    const studentsRequests = ref([])
    const departmentRefuseCauses = ref([])
    const companyRefuseCauses = ref([])

 

    const getInternshipRequests = async () => {
       
        await axios.get('/internshipRequests').then((response) => {
            studentsRequests.value = response.data.data
        })
    }
    const getInternshipsIAccepted = async () => {
        await axios.get('/internships/students').then((response) => {
            studentsRequests.value = response.data.data
        })
    }
    const getMyPassedInternships = async () => {
        // As student
        await axios.get('/internships/passed').then((response) => {
            studentsRequests.value = response.data.data
        })
    }


    const storeInternshipRequest = async (internshipRequest) => {
       
        await axios.post('/internshipRequests', internshipRequest)
    }
    const updateInternshipRequest = async (id, internshipRequest) => {
       
        await axios.patch('/internshipRequests/' + id, internshipRequest)
    }
    const destroyInternshipRequest = async (id) => {
       
        await axios.delete('/internshipRequests/' + id)
    }


    const manageInternshipRequests = async (decision, internship_request_id) => {
       
        await axios.post('/internshipRequests/manage/' + internship_request_id, decision)
    }


    // this should be in another file

    const getDepartmentRefuseCauses = async () => {
       
        await axios.get('/departmentCauses').then((response) => {
            departmentRefuseCauses.value = response.data.data
        })
    }
    const getCompanyRefuseCauses = async () => {
       
        await axios.get('/companyCauses').then((response) => {
            companyRefuseCauses.value = response.data.data
        })
    }


    const storeDepartmentRefuseCause = async (cause) => {
       
        await axios.post('/departmentCauses', cause).then((response) => {
            newCause.value = response.data.data
        })
    }
    const storeCompanyRefuseCause = async (cause) => {
       
        await axios.post('/companyCauses', cause).then((response) => {
            newCause.value = response.data.data
        })
    }



    return {
        getInternshipRequests,
        getMyPassedInternships,
        getDepartmentRefuseCauses,
        getCompanyRefuseCauses,
        manageInternshipRequests,
        storeDepartmentRefuseCause,
        storeCompanyRefuseCause,
        getInternshipsIAccepted,
        storeInternshipRequest,
        updateInternshipRequest,
        destroyInternshipRequest,

        departmentRefuseCauses,
        companyRefuseCauses,
        newCause,
        studentsRequests,
    }
}