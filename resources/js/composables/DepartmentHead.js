import { ref } from "vue"

export default () => {

    const department_heads = ref([]);
    const update_department_head = async (id, department_head) => {
        await axios.patch("/department-heads/" + id, department_head)
    }
    
    const get_department_heads = async () => {
        await axios.get("/department-heads").then((response) => {
            department_heads.value = response.data.data
        })
    }

    const store_department_head = async (department_head) => {
        await axios.post('/department-heads', department_head)
    }

    const destroy_department_head = async (id) => {
        await axios.delete('/department-heads/' + id)
    }

    return {
        get_department_heads,
        store_department_head,
        update_department_head,
        destroy_department_head,
        department_heads,
    }
}