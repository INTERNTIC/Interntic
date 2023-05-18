import { ref } from "vue"

export default ()=> {
    // TODO trancfere lervel to a file and majors to its file
    const students = ref([])
    const levels = ref([])
    const majors = ref([])

    const storeStudent = async (credentials) => {
        await axios.post('/addStudentInfo', credentials)
    
    }

    const updateStudent = async (student) => {

        await axios.patch('/editStudentInfo/' + student.id, student)
    }

    const getStudents = async () => {
        await axios.get('/displayStudents').then((response) => {
            students.value = response.data.data
        })
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
        storeStudent,
        getMajorsOfLevel,
        getLevels,
        destroyStudent,
        updateStudent,

        students,
        levels,
        majors,
    }
}