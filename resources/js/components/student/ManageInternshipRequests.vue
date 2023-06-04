<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';


import useInternshipRequest from '@/composables/InternshipRequests.js';
import { Notify, getErrorText, refreshTable } from "@/newShared";
import SelectInput from '../form/SelectInput.vue';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
import {
    getCompanies,
    storeCompany,
    companies,
    newCompany,
} from '@/composables/Company.js';


const {
    getInternshipRequests,
    storeInternshipRequest,
    updateInternshipRequest,
    destroyInternshipRequest,
    studentsRequests,

} = useInternshipRequest();
let addNewCompany = ref(false);

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

const saveNewCompany = async () => {
    await storeCompany(newCompany.value);
    if (generalErrorMsg.value == "") {
        await getCompanies();
        currentInternshipsRequest.value.company_id = newCompany.value.id
        addNewCompany.value = false;
    }
}
const saveInternshipsRequest = async () => {
    if (currentInternshipsRequest.value.id == "") {
        await storeInternshipRequest(currentInternshipsRequest.value);
    } else {
        await updateInternshipRequest(currentInternshipsRequest.value.id, currentInternshipsRequest.value)
    }
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getInternshipRequests();
        currentInternshipsRequest.value = _.cloneDeep(internshipsRequestObject);
        $("#full-width-modal").modal("hide");
    }
}
const openEditModal = async (internships_request) => {
    currentInternshipsRequest.value = internships_request
    $('#full-width-modal').modal('show')

}
const openDeleteModal = async (internships_request_id) => {
    currentInternshipsRequest.value.id = internships_request_id
    $("#danger-header-modal").modal("show");

}
const deleteInternshipRequest = async () => {
    await destroyInternshipRequest(currentInternshipsRequest.value.id);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getInternshipRequests();
        currentInternshipsRequest.value = _.cloneDeep(internshipsRequestObject);
        $("#danger-header-modal").modal("hide");
    }
}


onMounted(async () => {
    await getInternshipRequests();
    await getCompanies();
});




</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Manage Internship Requests</h4>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">Add a Request</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="internship in studentsRequests" :key="internship.id" class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ internship.theme }}</h4>
                    <p class="font-14">from: <span class="text-muted"> {{ internship.start_at }}</span> to: <span
                            class="text-muted">{{ internship.end_at }}</span> </p>
                    <p class="text-muted font-14">Internship Boss Email : {{ internship.internshipResponsible_email }} </p>
                    <p class="text-muted font-14">Company : <b> {{ internship.company.name }}</b> , <b>
                            {{ internship.company.location }}</b> </p>

                    <div>
                        <button type="button" @click="openEditModal(internship)" class="btn btn-warning me-2">Edit</button>
                        <button type="button" @click="openDeleteModal(internship.id)" class="btn btn-danger">Delete</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <FullWidthModal modal_heading="Request Internship">
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.theme"
                                        :errorText="getErrorText(errors, 'theme')"
                                        :showError="errors.hasOwnProperty('theme')" label="Enter The Theme"
                                        placeholder="Enter The Theme" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternshipsRequest.internshipResponsible_email"
                                        :errorText="getErrorText(errors, 'internshipResponsible_email')"
                                        :showError="errors.hasOwnProperty('internshipResponsible_email')"
                                        label="Enter internship Responsible's email"
                                        placeholder="Enter internship Responsible's email" />
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
                                <template v-if="addNewCompany">
                                    <div v-if="addNewCompany" class="col-lg-6">
                                        <CustomInput v-model="newCompany.name" label="Company Name"
                                            placeholder="Enter Company Name" :errorText="getErrorText(errors, 'name')"
                                            :showError="errors.hasOwnProperty('name')" />
                                    </div>
                                    <div v-if="addNewCompany" class="col-lg-6">
                                        <CustomInput v-model="newCompany.location" label="Company Location"
                                            placeholder="Enter Company Location"
                                            :errorText="getErrorText(errors, 'location')"
                                            :showError="errors.hasOwnProperty('location')" />
                                    </div>
                                    <div v-if="addNewCompany" class="col-lg-6">

                                        <button @click="saveNewCompany" type="button"
                                            class="btn btn-info me-2">Submit</button>
                                        <button @click="addNewCompany = false" type="button"
                                            class="btn btn-light">Cancel</button>
                                    </div>
                                </template>


                                <div v-else class="col-lg-6">
                                    <SelectInput propertyOfValue="id" property-of-show="name" dividing=","
                                        second-property-of-show="location" placeholder="Select a Company"
                                        v-model="currentInternshipsRequest.company_id"
                                        :errorText="getErrorText(errors, 'company_id')"
                                        :showError="errors.hasOwnProperty('company_id')" label="Select a Company"
                                        :options="companies" />


                                    <button @click="addNewCompany = true" type="button" class="btn btn-info ">Add New
                                        Company</button>
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

    <DangerModalOutline>
        <template v-slot:body>
            are you sure you want to continue?
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteInternshipRequest" type="button" class="btn btn-danger"
                data-bs-dismiss="modal">Continue</button>
        </template>
    </DangerModalOutline>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









