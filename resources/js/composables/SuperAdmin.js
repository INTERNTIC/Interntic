import { ref } from "vue"

export default ()=> {

    const super_admins = ref([])

    const get_super_admins = async () => {
        await axios.get('/super-admins').then((response) => {
            super_admins.value = response.data.data
        })
    }
    const store_super_admin = async (super_admin) => {
        await axios.post('/super-admins', super_admin)
    }
    const update_super_admin = async (id,super_admin) => {
        
        await axios.patch('/super-admins/'+id, super_admin)
    }
    const destroy_super_admin = async (id) => {
        
        await axios.delete('/super-admins/'+id)
    }

    return {
        get_super_admins,
        store_super_admin,
        update_super_admin,
        destroy_super_admin,
        super_admins,
    }
}