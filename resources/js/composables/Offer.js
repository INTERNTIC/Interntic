import { useRouter } from "vue-router"
import { ref } from "vue"
export default function useOffer() {
    const router = useRouter();

    const offers = ref([])
    const offersPagination = ref({})

    const errors = ref({})
    const generalErrorMsg = ref('')
    const generalSuccessMsg = ref('')

    
    const restErrorsAndSuccess = () => {
        errors.value = {}
        generalErrorMsg.value = '';
        generalSuccessMsg.value = '';
    }
    const handleError = (error) => {
        if (error.response.status == 422) {
            errors.value = error.response.data.errors;
            generalErrorMsg.value = error.response.data.message;
        } else if (error.response.status == 450) {
                generalErrorMsg.value = error.response.data.msg;
            } else if (error.response.status == 404) {
                    generalErrorMsg.value = error.response.statusText;
                    router.push({ name: "PageNotFound" })
                } else {
                    generalErrorMsg.value = "Oppps !! Something went wrong";
                }
    }



    const getOffers = async (url='/displayOffers') => {
        restErrorsAndSuccess()
        await axios.get(url).then((response) => {
            offers.value = response.data.data.data
            offersPagination.value=response.data.data
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    // const getOffersNextPage = async (url='/displayOffers') => {
    //     restErrorsAndSuccess()
    //     await axios.get('url').then((response) => {
    //         offers.value = response.data.data.data
    //         offersPagination.value=response.data.data
    //     }).catch((error) => {
    //         if (error.response) {
    //             handleError(error)
    //         }
    //     })
    // }

    const storeOffer = async (offer) => {
        restErrorsAndSuccess()
        await axios.post('/addOffer', offer).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const updateOffer = async (id,offer) => {
        restErrorsAndSuccess()
        await axios.patch('/editOffer/'+id, offer).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    const destroyOffer = async (id) => {
        restErrorsAndSuccess()
        await axios.delete('/deleteOffer/'+id).then((response) => {
            generalSuccessMsg.value = response.data.msg
        }).catch((error) => {
            if (error.response) {
                handleError(error)
            }
        })
    }
    return {
        getOffers,
        storeOffer,
        updateOffer,
        destroyOffer,
        offers,
        offersPagination,
        generalErrorMsg,
        generalSuccessMsg,
        errors
    }
}