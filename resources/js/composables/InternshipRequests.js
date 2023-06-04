import { ref } from "vue";



export default () => {

    const newCause = ref({
        id: null,
        cause: ""
    });
    const studentsRequests = ref([])
    const refusedRequests = ref([])
    const passedInternships= ref([])
    const internshipsAcceptedByDepartmentHead = ref([])
    const internshipsAcceptedByInternshipResponsible = ref([])
    const departmentRefuseCauses = ref([])
    const companyRefuseCauses = ref([])



    const getInternshipRequests = async () => {

        await axios.get('/internshipRequests').then((response) => {
            studentsRequests.value = response.data.data
        })
    }
    const getInternshipsAcceptedByInternshipResponsible = async () => {
        await axios.get('/internships/accepted-by-internship-responsible').then((response) => {
            internshipsAcceptedByInternshipResponsible.value = response.data.data
        })
    }
    const getInternshipsAcceptedByDepartmentHead = async () => {
        await axios.get('/internships/accepted-by-department-head').then((response) => {
            internshipsAcceptedByDepartmentHead.value = response.data.data
        })
    }
    const getInternshipsAcceptedByStudent = async () => {
        await axios.get('/internships/accepted-by-student').then((response) => {
            studentsRequests.value = response.data.data
        })
    }
    const getMyPassedInternships = async () => {
        // As student
        await axios.get('/internships/passed').then((response) => {
            passedInternships.value = response.data.data
        })
    }
    const getRefusedInternships = async () => {
        // As student
        await axios.get('/internships/refused').then((response) => {
            refusedRequests.value = response.data.data
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
    const accept_internship = async (internship_request_id) => {
        // only student
        await axios.post('/internships/accept/' + internship_request_id,)
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
        accept_internship,
        storeDepartmentRefuseCause,
        storeCompanyRefuseCause,
        getInternshipsAcceptedByInternshipResponsible,
        getInternshipsAcceptedByDepartmentHead,
        getInternshipsAcceptedByStudent,
        getRefusedInternships,
        storeInternshipRequest,
        updateInternshipRequest,
        destroyInternshipRequest,

        departmentRefuseCauses,
        companyRefuseCauses,
        newCause,
        studentsRequests,
        passedInternships,
        refusedRequests,
        internshipsAcceptedByDepartmentHead,
        internshipsAcceptedByInternshipResponsible,
    }
}