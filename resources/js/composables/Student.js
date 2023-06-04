import { ref } from "vue"

export default ()=> {
    // TODO trancfere lervel to a file and majors to its file
    const students = ref([])
    const student = ref({})
    const levels = ref([])
    const majors = ref([])

    const getStudents = async () => {
        await axios.get('/displayStudents').then((response) => {
            students.value = response.data.data
        })
    }
    const get_student = async (student_id) => {
        await axios.get('/getStudent/'+student_id).then((response) => {
            student.value = response.data.data
        })
    }
    const storeStudent = async (credentials) => {
        await axios.post('/addStudentInfo', credentials)
    
    }

    const updateStudent = async (student) => {

        await axios.patch('/editStudentInfo/' + student.id, student)
    }

    const destroyStudent = async (student_id) => {
        
        await axios.delete('/deleteStudent/' + student_id)
    }

    // TODO move to another file
    const getMajorsOfLevel = async (id) => {

        await axios.get('/levels/majors/' + id).then((response) => {
            majors.value = response.data.data
        })
    }
    const getLevels = async () => {

        await axios.get('/levels').then((response) => {
            levels.value = response.data.data

        })
    }
    return {
        getStudents,
        get_student,
        storeStudent,
        getMajorsOfLevel,
        getLevels,
        destroyStudent,
        updateStudent,

        students,
        student,
        levels,
        majors,
    }
}