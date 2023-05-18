
import { ref } from "vue"

export default ()=> {

    const department_causes = ref([])
    const get_department_causes = async () => {
        await axios.get('/departmentCauses').then((response) => {
            department_causes.value = response.data.data
        })
    }
    const store_department_cause = async (department_cause) => {
        await axios.post('/departmentCauses', department_cause)
    }
    const update_department_cause = async (id,department_cause) => {
        
        await axios.patch('/departmentCauses/'+id, department_cause)
    }
    const destroy_department_cause = async (id) => {
        
        await axios.delete('/departmentCauses/'+id)
    }

    return {
        get_department_causes,
        store_department_cause,
        update_department_cause,
        destroy_department_cause,
        department_causes,
    }
}