<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import TimePicker from '@/components/form/TimePicker.vue';
import useAssessment from '@/composables/Assessment.js';
import shared from "@/shared";
import SuccessModal from '../modal/SuccessModal.vue';
import SelectInput from '../form/SelectInput.vue';
import FloatingInput from '../form/FloatingInput.vue';
import { useLoading } from 'vue-loading-overlay'
import DatePicker from '../form/datePicker.vue';
import CustomTextAria from '../form/CustomTextAria.vue';

const $loading = useLoading({
});


const {
    getStudentInternshipsNotAssessed,
    storeAssessment,

    studentInternshipsNotAssessed,
    generalErrorMsg,
    generalSuccessMsg,
    errors
} = useAssessment();

const internshipsExemple = {
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
        email: "",
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
    company: {
        name: '',
        location: '',
    },
}
const assessmentExemple = {
    "the_date": new Date().toISOString().slice(0, 10),
    "enter_time": "",
    "left_time": "",
    "note": "",
    "internship_request_id": ""
}
const assessment = ref(Object.create(assessmentExemple))
const currentInternship = ref(Object.create(internshipsExemple))
const rangeTime = ref()
let principleTable = null;


$(document).on('click', 'tr button', async (e) => {
    assessment.value.the_date = new Date().toISOString().slice(0, 10);
    const internship_id = e.currentTarget.getAttribute('internship_id')
    currentInternship.value = studentInternshipsNotAssessed.value.find(internship => internship.id == internship_id);
});

const saveAssessment = async () => {
    assessment.value.internship_request_id = currentInternship.value.id

    getTimeFromRange()
    await storeAssessment(assessment.value)
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudentInternshipsNotAssessed();
        shared.refreshTable(principleTable, studentInternshipsNotAssessed.value)
        currentInternship.value = Object.create(internshipsExemple)
    }
    assessment.value = Object.create(assessmentExemple)


}

const getTimeFromRange = () => {
    if (rangeTime.value == undefined) {
        return
    } else {
        // formating time as H:i , adding 0 in front of number if is less then 10 
        assessment.value.enter_time = `${String(rangeTime.value[0].hours).padStart(2, '0')}:${rangeTime.value[0].minutes}:00`

        assessment.value.left_time = `${String(rangeTime.value[1].hours).padStart(2, '0')}:${rangeTime.value[1].minutes}:00`
    }
}
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
                return ` 
                        <button  button_type="edit" internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">View</button>
                        <button type="button" internship_id='${data.id}' data-bs-toggle="modal"  data-bs-target="#full-width-modal-assessment"
                        class="btn btn-success  btn-sm">Assess</button>
                        `;
            }
        },
    ];







onMounted(async () => {
    await getStudentInternshipsNotAssessed()
    import('@/assets/js/vendor/jquery.dataTables.min.js').then(() => {
        import('@/assets/js/vendor/dataTables.bootstrap5.js').then(() => {
            import('@/assets/js/vendor/dataTables.responsive.min.js').then(() => {
                import('@/assets/js/vendor/responsive.bootstrap5.min.js').then(() => {
                    console.log('nothing');
                    $('.timepicker').timepicker({});
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
                        data: studentInternshipsNotAssessed.value,
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
                            <h4 class="header-title">Internship Information </h4>
                            <p class="text-muted font-14">
                                Manage Student Internship
                            </p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput
                                        :modelValue="`${currentInternship.student.first_name} ${currentInternship.student.last_name}`"
                                        :readonly="true" label="Student Full Name" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.student.student_card_number"
                                        :readonly="true" label="Student Student Card" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.student.major" :readonly="true"
                                        label="Student Major" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.student.email" :readonly="true"
                                        label="Student Email" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.student.level" :readonly="true"
                                        label="Student Level" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.theme" :readonly="true"
                                        label="Internship Theme" inputType="text" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentInternship.internshipResponsible_email"
                                        :readonly="true" label="Internship responsible email" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.start_at" :readonly="true"
                                        label="Internship Start at" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.end_at" :readonly="true"
                                        label="Internship End at" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.company.name" :readonly="true"
                                        label="Internship Company Name" inputType="text" />
                                    <CustomInput :modelValue="currentInternship.company.location" :readonly="true"
                                        label="Internship Company Location" inputType="text" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </template>
    </FullWidthModal>
    <FullWidthModal modalId="full-width-modal-assessment">
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Assess Student </h4>
                            <p class="text-muted font-14">
                                Assess Student
                            </p>
                            <form class="row">

                                <div class="col-lg-6">
                                    <CustomInput v-model="assessment.the_date"
                                        :errorText="shared.getErrorText(errors, 'the_date')"
                                        :showError="errors.hasOwnProperty('the_date')" label="The Date" inputType="date"
                                        placeholder="Enter The Date" />
                                </div>


                                <div class="col-lg-6">
                                    <TimePicker v-model="rangeTime"
                                        :errorText="shared.getErrorText(errors, 'enter_time') + ' / ' + shared.getErrorText(errors, 'left_time')"
                                        :showError="errors.hasOwnProperty('enter_time') || errors.hasOwnProperty('left_time')"
                                        label="Enter Time / Left Time" placeholder="Enter the range" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomTextAria v-model="assessment.note"
                                        :errorText="shared.getErrorText(errors, 'note')"
                                        :showError="errors.hasOwnProperty('note')" label="Enter a Note"
                                        placeholder="Enter a Note" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="saveAssessment" type="button" class="btn btn-success" data-bs-dismiss="modal">Submit</button>
        </template>
    </FullWidthModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









