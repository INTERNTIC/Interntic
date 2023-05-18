
import { ref } from "vue"

export default ()=> {

    const company_causes = ref([])
    const get_company_causes = async () => {
        await axios.get('/companyCauses').then((response) => {
            company_causes.value = response.data.data
        })
    }
    const store_company_cause = async (company_cause) => {
        await axios.post('/companyCauses', company_cause)
    }
    const update_company_cause = async (id,company_cause) => {
        
        await axios.patch('/companyCauses/'+id, company_cause)
    }
    const destroy_company_cause = async (id) => {
        
        await axios.delete('/companyCauses/'+id)
    }

    return {
        get_company_causes,
        store_company_cause,
        update_company_cause,
        destroy_company_cause,
        company_causes,
    }
}