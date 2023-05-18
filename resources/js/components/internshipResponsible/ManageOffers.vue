<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';

import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';

import useOffer from '@/composables/Offer.js';
import {Notify,getErrorText,refreshTable} from "@/newShared";
import SuccessModal from '../modal/SuccessModal.vue';
import SelectInput from '../form/SelectInput.vue';
import CustomTextAria from '../form/CustomTextAria.vue';
import { computed } from 'vue';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
}from "@/axiosClient";

const {
    getOffers,
    storeOffer,
    updateOffer,
    destroyOffer,
    offersPagination,
    offers,
} = useOffer();

const OfferObject = {
    "id": "",
    "theme": "",
    "duration": "",
    "details": "",
};
const currentOffer = ref(_.cloneDeep(OfferObject))

const saveOffer = async () => {
    if (currentOffer.value.id == '') {
        await storeOffer(currentOffer.value);
    } else {
        await updateOffer(currentOffer.value.id, currentOffer.value)
    }
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getOffers();
        currentOffer.value = _.cloneDeep(OfferObject)
        $('#full-width-modal').modal('hide')
    }
}
const deleteOffer = async () => {
    await destroyOffer(currentOffer.value.id);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getOffers();
        currentOffer.value = _.cloneDeep(OfferObject)
    }
}
const openDeleteModal = (id) => {
    currentOffer.value.id = id;
    $('#danger-header-modal').modal('show')
}
const openEditModal = (offer) => {
    currentOffer.value = offer;
    $('#full-width-modal').modal('show')
}

const isPaginationActive = computed(
    () => {
        return offersPagination.value.links?.next != offersPagination.value.links?.prev;
    }
)
const isActive = computed(
    () => function (page_index) {
        return offersPagination.value.meta.current_page == page_index;
    }
)
const nextLink = computed(
    () => {
        return offersPagination.value.links?.next
    }
)
const prevLink = computed(
    () => {
        return offersPagination.value.links?.prev
    }
)
onMounted(async () => {
    await getOffers()
});




</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Manage Students</h4>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">Add Offer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="offer in offers" :key="offer.id" class="col-lg-6">
            <div  class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ offer.theme }}</h4>
                    <p class="text-muted font-14">{{ offer.duration }}</p>
                    <p class=" font-14">{{ offer.details }}</p>
                    <div>
                        <button type="button" @click="openEditModal(offer)" class="btn btn-warning me-2">Edit</button>
                        <button type="button" @click="openDeleteModal(offer.id)" data-bs-toggle="modal"
                            data-bs-target="#danger-header-modal" class="btn btn-danger">Delete</button>

                    </div>
                </div> <!-- end card-body -->
        </div>
        </div>
    
        <nav v-if="isPaginationActive" >
            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                <li class="page-item">
                    <button :disabled="prevLink == null"  class="page-link" role="button" @click="getOffers(prevLink)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>
                <li v-for="page_index in offersPagination.meta.last_page" class="page-item" :class="{ 'active': isActive(page_index) }"><a
                        class="page-link" @click="getOffers(`/displayOffers?page=${page_index}`)" role="button">{{ page_index }}</a></li>
                <li class="page-item">
                    <button :disabled="nextLink== null" class="page-link" role="button" @click="getOffers(nextLink)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div> <!-- end row-->
    <!-- Full width modal -->
    <FullWidthModal>
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Internship Offer</h4>
                            <p class="text-muted font-14">
                                Enter Internship offer Details
                            </p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentOffer.theme"
                                        :errorText="getErrorText(errors, 'theme')"
                                        :showError="errors.hasOwnProperty('theme')" label="Enter The Theme"
                                        placeholder="Enter The Theme" />
                                    <CustomInput v-model="currentOffer.duration"
                                        :errorText="getErrorText(errors, 'duration')"
                                        :showError="errors.hasOwnProperty('duration')" label="Enter a Duration"
                                        placeholder="Enter a Duration" />
                                </div>
                                <div class="col-lg-6">

                                    <CustomTextAria v-model="currentOffer.details"
                                        :errorText="getErrorText(errors, 'details')"
                                        :showError="errors.hasOwnProperty('details')" label="Enter a Details"
                                        placeholder="Enter a Details" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="saveOffer" type="button" class="btn btn-success">Save</button>
        </template>
    </FullWidthModal>

    <DangerModalOutline>
        <template v-slot:body>
            are you sure you want to continue?
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteOffer" type="button" class="btn btn-danger" data-bs-dismiss="modal">Continue</button>
        </template>
    </DangerModalOutline>
</template>
<style scoped>
button[disabled] {
    color: gray;
    opacity: 0.5;
    cursor: not-allowed;
}
</style>









