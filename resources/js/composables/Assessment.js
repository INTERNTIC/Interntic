import { ref } from "vue"

export default ()=>{
    
    const studentInternshipsNotAssessed = ref([])
    const studentInternships = ref([])
    const assessments = ref([])

    const getStudentInternshipsNotAssessed = async () => {
        await axios.get('/internships/students/not-assessed').then((response) => {
            studentInternshipsNotAssessed.value = response.data.data
        })
    }
    const getAssessment = async () => {
       
        await axios.get('/assessments').then((response) => {
            assessments.value = response.data.data
        })
    }
    const storeAssessment = async (assessment) => {
        await axios.post('/assessments', assessment)
    }

    const updateAssessment = async (id,assessment) => {
        await axios.patch('/assessments/'+id, assessment)
    }

    const destroyAssessment = async (id) => {
        await axios.delete('/assessments/'+id);
    }
    return {
        getStudentInternshipsNotAssessed,
        getAssessment,
        storeAssessment,
        updateAssessment,
        destroyAssessment,
        assessments,
        studentInternshipsNotAssessed,
        studentInternships,
    }
}