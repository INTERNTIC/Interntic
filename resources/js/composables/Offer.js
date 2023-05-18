
import { ref } from "vue"
export default ()=> {


    const offers = ref([])
    const offersPagination = ref({})


    
    const getOffers = async (url='/displayOffers') => {
        
        await axios.get(url).then((response) => {
            offers.value = response.data.data
            offersPagination.value=response.data
        })
    }
    const storeOffer = async (offer) => {
        
        await axios.post('/addOffer', offer)
    }
    const updateOffer = async (id,offer) => {
        
        await axios.patch('/editOffer/'+id, offer)
    }
    const destroyOffer = async (id) => {
        
        await axios.delete('/deleteOffer/'+id)
    }
    return {
        getOffers,
        storeOffer,
        updateOffer,
        destroyOffer,
        offers,
        offersPagination,
    }
}