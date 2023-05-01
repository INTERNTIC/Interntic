<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import useOffer from '@/composables/Offer.js';
import shared from "@/shared";
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
    offersPagination,
    offers,
    } = useOffer();

const internshipsRequestObject = {
    id: '',
    student_id: '',
    internshipResponsible_email: '',
    theme: '',
    start_at: '',
    end_at: '',
    company_id: ""
}

const currentInternshipsRequest = ref(_.cloneDeep(internshipsRequestObject))

// const saveOffer = async () => {
//     if (currentOffer.value.id == '') {
//         await storeOffer(currentOffer.value);
//     } else {
//         await updateOffer(currentOffer.value.id, currentOffer.value)
//     }
//     shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
//     if (generalErrorMsg.value == "") {
//         await getOffers();
//         currentOffer.value = _.cloneDeep(OfferObject)
//         $('#full-width-modal').modal('hide')
//     }
// }
const openSelectModal = (offer) => {
    currentInternshipsRequest.value.theme=offer.theme;
    currentInternshipsRequest.value.internshipResponsible_email=offer.internship_responsible.email;
    currentInternshipsRequest.value.company_id=offer.internship_responsible.company_id;
    $('#full-width-modal').modal('show')
}

const isActive = computed(
    () => function (page_index) {
        return offersPagination.value.current_page == page_index;
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
                        <button type="button" @click="openSelectModal(offer)" class="btn btn-warning me-2">Select</button>

                    </div>
                </div> <!-- end card-body -->
            </div>
        </div>
        <nav>
            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                <li class="page-item">
                    <a class="page-link" role="button" @click="getOffers(offersPagination.prev_page_url)"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="page_index in offersPagination.last_page" class="page-item"
                    :class="{ 'active': isActive(page_index) }"><a class="page-link"
                        @click="getOffers(`/displayOffers?page=${page_index}`)" role="button">{{ page_index }}</a></li>
                <li class="page-item">
                    <a class="page-link" role="button" @click="getOffers(offersPagination.next_page_url)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
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
                                    <CustomInput v-model="currentInternshipsRequest.theme"
                                        :errorText="shared.getErrorText(errors, 'theme')"
                                        :showError="errors.hasOwnProperty('theme')" label="Enter The Theme"
                                        placeholder="Enter The Theme" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.internshipResponsible_email"
                                        :errorText="shared.getErrorText(errors, 'internshipResponsible_email')"
                                        :showError="errors.hasOwnProperty('internshipResponsible_email')"
                                        label="Enter internship Responsible's email"
                                        placeholder="Enter internship Responsible's email" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.start_at"
                                        :errorText="shared.getErrorText(errors, 'start_at')"
                                        :showError="errors.hasOwnProperty('start_at')" label="Start at" inputType="date"
                                        placeholder="Start at Date" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.end_at"
                                        :errorText="shared.getErrorText(errors, 'end_at')"
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
            <button @click="saveInternshipsRequest" type="button" class="btn btn-success">Save</button>
        </template>
    </FullWidthModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









