
import { ref } from "vue"

export default ()=> {
    const new_cause = ref({
        id: null,
        cause: ""
    });

    const department_causes = ref([])
    const department_causes_pagination = ref({})
    const get_department_causes = async (page_inedx="1") => {
        await axios.get("/departmentCauses?page="+page_inedx).then((response) => {
            department_causes_pagination.value=response.data
            department_causes.value = response.data.data
        })
    }
    const get_department_causes_all = async () => {
        await axios.get("/departmentCauses/get_all").then((response) => {
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
        get_department_causes_all,
        get_department_causes,
        store_department_cause,
        update_department_cause,
        destroy_department_cause,
        department_causes,
        new_cause,
        department_causes_pagination,
    }
}