<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import useOffer from '@/composables/Offer.js';
import useInternshipRequest from '@/composables/InternshipRequests.js';
import SuccessModal from '../modal/SuccessModal.vue';
import SelectInput from '../form/SelectInput.vue';
import CustomTextAria from '../form/CustomTextAria.vue';
import { computed } from 'vue';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
import {Notify,getErrorText} from "@/newShared" 

const {
    getOffers,
    offersPagination,
    offers,
} = useOffer();
const {
    storeInternshipRequest
} = useInternshipRequest();

const internshipsRequestObject = {
    id: '',
    student_id: '',
    internshipResponsible_email: '',
    theme: '',
    start_at: '',
    end_at: '',
    company_id: ""
}
const offerObject = {
    internship_responsible_email: '',
    theme: '',
}

const currentInternshipsRequest = ref(_.cloneDeep(internshipsRequestObject))
// const currentOffer = ref(_.cloneDeep(offerObject))

// const saveOffer = async () => {
//     if (currentOffer.value.id == '') {
//         await storeOffer(currentOffer.value);
//     } else {
//         await updateOffer(currentOffer.value.id, currentOffer.value)
//     }
//     Notify(generalSuccessMsg.value, generalErrorMsg.value)
//     if (generalErrorMsg.value == "") {
//         await getOffers();
//         currentOffer.value = _.cloneDeep(OfferObject)
//         $('#full-width-modal').modal('hide')
//     }
// }
const openSelectModal = (offer) => {
    offerObject.theme = offer.theme;
    offerObject.internship_responsible_email = offer.internship_responsible.email
    currentInternshipsRequest.value.theme = offer.theme;
    currentInternshipsRequest.value.internshipResponsible_email = offer.internship_responsible.email;
    currentInternshipsRequest.value.company_id = offer.internship_responsible.company_id;
    $('#full-width-modal').modal('show')
}

const applyInternshipsRequest = async () => {
    await storeInternshipRequest(currentInternshipsRequest.value)

    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
         currentInternshipsRequest.value = _.cloneDeep(internshipsRequestObject)
    }
}
const isActive = computed(
    () => function (page_index) {
        return offersPagination.value.meta?.current_page == page_index;
    }
)
const isPaginationActive = computed(
    () => {
        return offersPagination.value.links?.next != offersPagination.value.links?.prev;
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
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Choose an Offer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="offer in offers" :key="offer.id" class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ offer.theme }}</h4>
                    <p class="text-muted font-14">{{ offer.duration }}</p>
                    <p class=" font-14">{{ offer.details }}</p>
                    <div>
                        <button type="button" @click="openSelectModal(offer)" class="btn btn-warning me-2">Apply</button>

                    </div>
                </div> <!-- end card-body -->
            </div>
        </div>
        <nav v-if="isPaginationActive">
            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                <li class="page-item">
                    <button :disabled="prevLink == null" class="page-link" @click="getOffers(prevLink)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>
                <li v-for="page_index in offersPagination.meta?.last_page" class="page-item"
                    :class="{ 'active': isActive(page_index) }"><a class="page-link"
                        @click="getOffers(`/displayOffers?page=${page_index}`)" role="button">{{ page_index }}</a></li>
                <li class="page-item">
                    <button :disabled="nextLink == null" class="page-link" @click="getOffers(nextLink)" aria-label="Next">
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
                                {{ currentInternshipsRequest }}
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="offerObject.theme"
                                        :errorText="getErrorText(errors, 'theme')"
                                        :showError="errors.hasOwnProperty('theme')" label="The Theme"
                                        placeholder="The Theme" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="offerObject.internship_responsible_email"
                                        :errorText="getErrorText(errors, 'internshipResponsible_email')"
                                        :showError="errors.hasOwnProperty('internshipResponsible_email')"
                                        label="internship Responsible's email"
                                        placeholder="internship Responsible's email" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.start_at"
                                        :errorText="getErrorText(errors, 'start_at')"
                                        :showError="errors.hasOwnProperty('start_at')" label="Start at" inputType="date"
                                        placeholder="Start at Date" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.end_at"
                                        :errorText="getErrorText(errors, 'end_at')"
                                        :showError="errors.hasOwnProperty('end_at')" label="End at" inputType="date"
                                        placeholder="End at Date" />
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="applyInternshipsRequest" type="button" class="btn btn-success">Apply</button>
        </template>
    </FullWidthModal>
</template>
<style scoped>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";

button[disabled] {
    color: gray;
    opacity: 0.5;
    cursor: not-allowed;
}
</style>









