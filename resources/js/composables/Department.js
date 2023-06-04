import { ref } from "vue"
export default () => {

    const departments = ref([]);

    const get_departments = async () => {
        await axios.get("/departments").then((response) => {
            departments.value  = response.data.data
        })
    }

    const update_department = async (id, department) => {
        await axios.patch('/departments/' + id, department)
    }

    const store_department = async (department) => {
        await axios.post('/departments', department)
    }

    const destroy_department = async (id) => {
        await axios.delete('/departments/' + id)
    }

    return {
        get_departments,
        store_department,
        update_department,
        destroy_department,
        departments,
    }
}