<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import useInternshipRequest from '@/composables/InternshipRequests.js';
import SuccessModal from '../modal/SuccessModal.vue';
import SelectInput from '../form/SelectInput.vue';
import {useLoading} from 'vue-loading-overlay'
import {getErrorText,errorNotify,Notify,refreshTable} from "@/newShared";
import {generalErrorMsg,
    generalSuccessMsg,
    errors} from "@/axiosClient";
const $loading = useLoading({
    });
const judgement = ref({
    decision: "",
    cause_id: ""
});
const createNewCause = ref(false)

const {
    getInternshipRequests,
    getDepartmentRefuseCauses,
    manageInternshipRequests,
    studentsRequests,
    departmentRefuseCauses,
    storeDepartmentRefuseCause,
    newCause,
   } = useInternshipRequest();

const internshipsRequestExemple = {
    id: '',
    student_id: '',
    internshipResponsible_email: '',
    theme: '',
    start_at: '',
    end_at: '',
    student: {
        id: '',
        first_name: '',
        last_name: '',
        birthday: '',
        place_of_birth: '',
        phone_number: '',
        student_card_number: '',
        social_security_num: '',
        level: '',
        major: '',
        level_id: '',
        major_id: '',
    },
    company:{
    name: '',
    location: '',
    },
}
const currentInternshipsRequest = ref(internshipsRequestExemple)
let principleTable = null;


$(document).on('click', 'tr button', async (e) => {
    const internship_request_id = e.currentTarget.getAttribute('internship_request_id')
    currentInternshipsRequest.value = studentsRequests.value.find(requst => requst.id == internship_request_id);
});
const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.student.first_name + "  " + row.student.last_name;
            }
        },
        { 'data': 'student.student_card_number' },
        { 'data': 'student.major' },
        { 'data': 'student.level' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button  button_type="edit" internship_request_id='${data.id}'  type="button" class="btn btn-dark btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">View</button>`;
            }
        },
    ];



const handelRequest = async (decision) => {
    if (decision == 'refuse' || decision == 'refuse_definitively') {
        if (judgement.value.cause_id == "") {
            errorNotify('please select a valid cause');
            return
        }
        $('#danger-header-modal').modal('hide')
        $('#info-header-modal').modal('show')

    }
    judgement.value.decision = decision
}
const submitHandeledRequest = async () => {
    const loader = $loading.show({
        color: 'green',
    });
    await manageInternshipRequests(judgement.value, currentInternshipsRequest.value.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getInternshipRequests()
        refreshTable(principleTable, studentsRequests.value)
        currentInternshipsRequest.value = internshipsRequestExemple
    }
    loader.hide()
}



const saveRefuseCause = async () => {
    await storeDepartmentRefuseCause(newCause.value);
    if (generalErrorMsg.value == "") {
        await getDepartmentRefuseCauses();
        judgement.value.cause_id = newCause.value.id
        createNewCause.value = false;
    }
}


onMounted(async () => {
    await getInternshipRequests()
    await getDepartmentRefuseCauses()
    import('@/assets/js/vendor/jquery.dataTables.min.js').then(() => {
        import('@/assets/js/vendor/dataTables.bootstrap5.js').then(() => {
            import('@/assets/js/vendor/dataTables.responsive.min.js').then(() => {
                import('@/assets/js/vendor/responsive.bootstrap5.min.js').then(() => {
                    principleTable = $("#scroll-horizontal-datatable").DataTable({
                        scrollX: !0,
                        language: {
                            paginate: {
                                previous: "<i class='mdi mdi-chevron-left'>",
                                next: "<i class='mdi mdi-chevron-right'>"
                            }
                        },
                        drawCallback: function () {
                            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                        },
                        data: studentsRequests.value,
                        columns: principleColumns
                    });

                });
            });
        });
    });
});




</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Manage Students Accounts</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Students</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All Students</h4>
                    <p class="text-muted font-14">
                        Here is a list of all students in the University
                    </p>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#basic-datatable-preview" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link active">
                                Preview
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-datatable-preview">
                            <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Card Number</th>
                                        <th>Major</th>
                                        <th>Level</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                        <!-- end preview-->
                    </div>
                   

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
    <!-- Full width modal -->
    <FullWidthModal>
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Internship Request</h4>
                            <p class="text-muted font-14">
                                Manage Student Request
                            </p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput
                                        :modelValue="`${currentInternshipsRequest.student.first_name} ${currentInternshipsRequest.student.last_name}`"
                                        :readonly="true" label="Student Full Name" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.student.student_card_number"
                                        :readonly="true" label="Student Student Card" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.student.major" :readonly="true"
                                        label="Student Major" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.student.level" :readonly="true"
                                        label="Student Level" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.theme" :readonly="true"
                                        label="Internship Theme" inputType="text" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentInternshipsRequest.internshipResponsible_email"
                                        :readonly="true" label="Internship responsible email" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.start_at" :readonly="true"
                                        label="Internship Start at" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.end_at" :readonly="true"
                                        label="Internship End at" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.company.name" :readonly="true"
                                        label="Internship Company Name" inputType="text" />
                                    <CustomInput :modelValue="currentInternshipsRequest.company.location" :readonly="true"
                                        label="Internship Company Location" inputType="text" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="handelRequest('accept')" type="button" data-bs-toggle="modal"
                data-bs-target="#success-header-modal" class="btn btn-success">Accept</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#danger-header-modal"
                class="btn btn-danger">Decline</button>
        </template>
    </FullWidthModal>
    <DangerModalOutline>
        <template v-slot:body>
            <SelectInput propertyOfValue="id" property-of-show="cause" placeholder="Select Refuse Cause"
                v-model="judgement.cause_id" :errorText="getErrorText(errors, 'cause_id')"
                :showError="errors.hasOwnProperty('cause_id')" label="Select Refuse Cause" :options="departmentRefuseCauses" />
            <div v-if="createNewCause" class="col-lg-6 mt-2">
                <CustomInput v-model="newCause.cause" label="New Cause" placeholder="Enter New Cause"
                    :errorText="getErrorText(errors, 'cause')" :showError="errors.hasOwnProperty('cause')" />
                <button @click="saveRefuseCause" type="button" class="btn btn-info">Submit</button>
                <button @click="createNewCause = false" type="button" class="btn btn-light">Cancel</button>

            </div>
            <button @click="createNewCause = true" v-else type="button" class="btn btn-info mt-2 ">Create a new
                Cause</button>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="handelRequest('refuse')" type="button" class="btn btn-warning">Refuse</button>
            <button @click="handelRequest('refuse_definitively')" type="button" class="btn btn-danger">Refuse
                definitively</button>
        </template>
    </DangerModalOutline>

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

    </InfoModalOutline>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>


