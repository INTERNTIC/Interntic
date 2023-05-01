import { ref } from "vue"

const companies = ref([])

const newCompany = ref({
    id: '',
    name: '',
    location: '',
});

const getCompanies = async () => {
    
    await axios.get('/companies')
    }
    
    const storeCompany = async (company) => {
        
        await axios.post('/companies', company).then((response) => {
            
            newCompany.value=response.data.data
        })
    }
    const updateCompany = async (id,company) => {
        
        await axios.patch('/companies/'+id, company)
    }
    const destroyCompany = async (id) => {
        
        await axios.delete('/companies/'+id)
    }
    
    export  {
    getCompanies,
    storeCompany,
    updateCompany,
    destroyCompany,
    
    companies,
    newCompany,    
}