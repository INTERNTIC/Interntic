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


const {
    getOffers,
    storeOffer,
    updateOffer,
    destroyOffer,
    offersPagination,
    offers,
    generalErrorMsg,
    generalSuccessMsg,
    errors } = useOffer();

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
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getOffers();
        currentOffer.value = _.cloneDeep(OfferObject)
        $('#full-width-modal').modal('hide')
    }
}
const deleteOffer = async () => {
    await destroyOffer(currentOffer.value.id);
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
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

const isActive = computed(
    () => function (page_index) {
        return offersPagination.value.current_page == page_index;
    }
    //   (page_index) => `${offersPagination.current_page==page_index}`
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
                <!-- <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Manage Students Accounts</li>
                    </ol>
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
            <div v-for="offer in offers" :key="offer.id" class="col-md-6">
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
        <nav >
            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                <li class="page-item">
                    <a class="page-link" role="button" @click="getOffers(offersPagination.prev_page_url)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="page_index in offersPagination.last_page" class="page-item" :class="{ 'active': isActive(page_index) }"><a
                        class="page-link" @click="getOffers(`/displayOffers?page=${page_index}`)" role="button">{{ page_index }}</a></li>
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
                                    <CustomInput v-model="currentOffer.theme"
                                        :errorText="shared.getErrorText(errors, 'theme')"
                                        :showError="errors.hasOwnProperty('theme')" label="Enter The Theme"
                                        placeholder="Enter The Theme" />
                                    <CustomInput v-model="currentOffer.duration"
                                        :errorText="shared.getErrorText(errors, 'duration')"
                                        :showError="errors.hasOwnProperty('duration')" label="Enter a Duration"
                                        placeholder="Enter a Duration" />
                                </div>
                                <div class="col-lg-6">

                                    <CustomTextAria v-model="currentOffer.details"
                                        :errorText="shared.getErrorText(errors, 'details')"
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
    <!--
    <SuccessModal>
        <template v-slot:body>
            Are you sure you want to accept this internship request ?
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="submitHandeledRequest" type="button" class="btn btn-success"
                data-bs-dismiss="modal">Accept</button>
        </template>
    </SuccessModal>
    <InfoModalOutline>
        <template v-slot:body>
            Are you sure you want to <b>{{ judgement.decision.split("_").join(" ") }}</b> this decision ?
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="submitHandeledRequest" type="button" class="btn btn-info"
                data-bs-dismiss="modal">Confirm</button>
        </template>

    </InfoModalOutline> -->
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









