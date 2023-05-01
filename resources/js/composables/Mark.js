
import { ref } from "vue"

export default function useInternship() {
    const studentMarks = ref([])


  
    const getStudentMarks = async () => {
        
        await axios.get('/marks').then((response) => {
            studentMarks.value = response.data.data
        })
    }
    
    const storeMark = async (mark) => {
        
        await axios.post('/marks', mark)
    }
    const updateMark = async (id,mark) => {
        
        await axios.patch('/marks/'+id, mark)
    }
    const destroyMark = async (id) => {
        
        await axios.delete('/marks/'+id)
    }
    return {
        getStudentMarks,
        storeMark,
        updateMark,
        destroyMark,

        studentMarks,
    }
}