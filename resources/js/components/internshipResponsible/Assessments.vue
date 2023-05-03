<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import TimePicker from '@/components/form/TimePicker.vue';
import UseAssessment from '@/composables/Assessment.js';
import {Notify,getErrorText,refreshTable} from "@/newShared";
import SuccessModal from '../modal/SuccessModal.vue';
import SelectInput from '../form/SelectInput.vue';
import FloatingInput from '../form/FloatingInput.vue';
import { useLoading } from 'vue-loading-overlay'
import DatePicker from '../form/datePicker.vue';
import CustomTextAria from '../form/CustomTextAria.vue';

import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
}from "@/axiosClient";

const $loading = useLoading({
});


const {
    getAssessment,
    updateAssessment,
    destroyAssessment,

    assessments,
} = UseAssessment();

const assessmentExemple = {
    the_date: '',
    enter_time: '',
    left_time: '',
    note: '',
    internship_request: {
        student: {
            first_name: "",
            last_name: "",
        }
    }
}

const currentAssessment = ref(Object.create(assessmentExemple))
let principleTable = null;

const rangeTime = ref(null)
$(document).on('click', 'tr button', async (e) => {
    const assessment_id = e.currentTarget.getAttribute('assessment_id')
    currentAssessment.value = assessments.value.find(assessment => assessment.id == assessment_id);
});



const saveAssessment = async () => {
    getTimeFromRange()
    await updateAssessment(currentAssessment.value.id, currentAssessment.value)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getAssessment();
        refreshTable(principleTable, assessments.value)
        currentAssessment.value = Object.create(assessmentExemple)
        rangeTime.value = null
        $('#edit-assessment-modal').modal('hide')
    }
}
const deleteAssessment = async () => {
    await destroyAssessment(currentAssessment.value.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getAssessment();
        refreshTable(principleTable, assessments.value)
        currentAssessment.value = Object.create(assessmentExemple)
    }
}

const getTimeFromRange = () => {
    if (rangeTime.value == null) {
        return
    } else {
        // formating time as H:i , adding 0 in front of number if is less then 10 
        currentAssessment.value.enter_time = `${String(rangeTime.value[0].hours).padStart(2, '0')}:${rangeTime.value[0].minutes}:00`

        currentAssessment.value.left_time = `${String(rangeTime.value[1].hours).padStart(2, '0')}:${rangeTime.value[1].minutes}:00`
    }
}







const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.internship_request.student.first_name + "  " + row.internship_request.student.last_name;
            }
        },
        { 'data': 'the_date' },
        { 'data': 'note' },
        {
            data: null,
            render: function (data, type, row) {
                return ` 
                    <button assessment_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#full-width-modal">View</button>
                    <button assessment_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#edit-assessment-modal">Edit</button>
                    <button assessment_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#danger-header-modal">Delete</button>
                    `;
            }
        },
    ];







onMounted(async () => {
    await getAssessment()
    import('@/assets/js/vendor/jquery.dataTables.min.js').then(() => {
        import('@/assets/js/vendor/dataTables.bootstrap5.js').then(() => {
            import('@/assets/js/vendor/dataTables.responsive.min.js').then(() => {
                import('@/assets/js/vendor/responsive.bootstrap5.min.js').then(() => {
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
                        data: assessments.value,
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Students List Today</h4>
                    </div>
                    <p class="text-muted font-14 ">
                        Here is a List of Students Who Were did not taken Attendance Today
                    </p>                   
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-datatable-preview">
                            <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Date</th>
                                        <th>Note</th>
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
                            <h4 class="header-title">Assessments Information </h4>
                            <p class="text-muted font-14">
                                Manage Student Assessments
                            </p>
                            <div class="row">
                                <div class="col-lg-6">

                                    <CustomInput :modelValue="currentAssessment.the_date" :readonly="true"
                                        label="The Date" />
                                    <CustomInput :modelValue="currentAssessment.enter_time" :readonly="true"
                                        label="Enter Time" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentAssessment.left_time" :readonly="true"
                                        label="Left Time" />
                                    <CustomInput :modelValue="currentAssessment.note" :readonly="true" label="Note" />
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
    <FullWidthModal modalId="edit-assessment-modal">
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Assessments Information </h4>
                            <p class="text-muted font-14">
                                Manage Student Assessments
                            </p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentAssessment.the_date"
                                        :errorText="getErrorText(errors, 'the_date')"
                                        :showError="errors.hasOwnProperty('the_date')" label="The Date" inputType="date"
                                        placeholder="Enter The Date" />
                                </div>


                                <div class="col-lg-6">
                                    <TimePicker v-model="rangeTime"
                                        :errorText="getErrorText(errors, 'enter_time') + ' / ' + getErrorText(errors, 'left_time')"
                                        :showError="errors.hasOwnProperty('enter_time') || errors.hasOwnProperty('left_time')"
                                        label="Enter Time / Left Time" placeholder="Enter the range"
                                        :mark="`current range : ${currentAssessment.enter_time} - ${currentAssessment.left_time}`" />
                                </div>

                                <div class="col-lg-6">
                                    <CustomTextAria 
                                    v-model="currentAssessment.note"
                                        :errorText="getErrorText(errors, 'note')"
                                        :showError="errors.hasOwnProperty('note')" label="Enter a Note"
                                        placeholder="Enter a Note" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            <button @click="saveAssessment" type="button" class="btn btn-dark">Update</button>
        </template>
    </FullWidthModal>
    <DangerModalOutline>
        <template v-slot:body>
            Are you sure you want to delete the day <b>{{ currentAssessment.the_date }} </b> of <b>
                {{
                    currentAssessment.internship_request.student.first_name }}
                {{ currentAssessment.internship_request.student.last_name }}
            </b>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteAssessment" type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
        </template>
    </DangerModalOutline>

</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









