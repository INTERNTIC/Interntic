
import { ref } from "vue"

export default ()=> {
    const new_cause = ref({
        id: null,
        cause: ""
    });

    const company_causes = ref([])
    const company_causes_pagination=ref({})

    const get_company_causes = async (page_index='1') => {
        await axios.get('/companyCauses?page='+page_index).then((response) => {
            company_causes_pagination.value=response.data
            company_causes.value = response.data.data
        })
    }
    const get_company_causes_all = async () => {
        await axios.get("/companyCauses/get_all").then((response) => {
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
        get_company_causes_all,
        get_company_causes,
        store_company_cause,
        update_company_cause,
        destroy_company_cause,
        new_cause,
        company_causes,
        company_causes_pagination
    }
}