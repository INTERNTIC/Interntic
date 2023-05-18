import { ref } from "vue"
export default ()=> {


    const cvItems = ref([])

    const getCvItems = async (url = '/studentCvItems') => {

        await axios.get(url).then((response) => {
            cvItems.value = response.data.data
        })
    }
    const storeCvItem = async (cvItem) => {

        await axios.post('/studentCvItems', cvItem, { headers: { 'Content-Type': 'multipart/form-data' } })
    }
    const updateCvItem = async (id, cvItem) => {

        await axios.post('/studentCvItems/' + id+'?_method=patch', cvItem, { headers: { 'Content-Type': 'multipart/form-data' } })
    
    }
    const destroyCvItem = async (id) => {

        await axios.delete('/studentCvItems/' + id)
    }
    return {
        getCvItems,
        storeCvItem,
        updateCvItem,
        destroyCvItem,
        cvItems,
    }
}