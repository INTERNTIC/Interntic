<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import TimePicker from '@/components/form/TimePicker.vue';
import useMark from '@/composables/Mark.js';
import useInternshipRequest from '@/composables/InternshipRequests.js';
import shared from "@/shared";
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
    getStudentMarks,
    storeMark,
    updateMark,
    destroyMark,

    studentMarks,
} = useMark();
const {
    getInternshipsIAccepted,
    studentsRequests,

} = useInternshipRequest();

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
const MarksExemple = {
    id: '',
    discipline: "12",
    skills: "12",
    initiative: "12",
    creativity: "12",
    knowledge: "12",
    internship_request_id: "",
}
const currentInternship = ref(Object.create(internshipsExemple))
const currentStudentMarks = ref(_.cloneDeep(MarksExemple))

let principleTable = null;


$(document).on('click', 'tr button', async (e) => {

    const internship_request_id = e.currentTarget.getAttribute('internship_id')
    currentInternship.value=studentsRequests.value.find(studentsMarks => studentsMarks.id == internship_request_id);
    currentStudentMarks.value = currentInternship?.value?.marks || _.cloneDeep(MarksExemple);
    currentStudentMarks.value.internship_request_id=internship_request_id;
});

const saveStudentMarks = async () => {
    if (currentStudentMarks.value.id=="") {
        await storeMark(currentStudentMarks.value)
    }else{
        await updateMark(currentStudentMarks.value.id, currentStudentMarks.value)
    }
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        await getInternshipsIAccepted();
        shared.refreshTable(principleTable, studentsRequests.value)
        currentStudentMarks.value = _.cloneDeep(MarksExemple)
        $('#full-width-modal').modal('hide')

    }
}

const deleteMarks = async () => {
    await destroyMark(currentStudentMarks.value.id)
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        await getInternshipsIAccepted();
        shared.refreshTable(principleTable, studentsRequests.value)
        currentStudentMarks.value = _.cloneDeep(MarksExemple)
        $('#danger-header-modal').modal('hide')

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


                if (data.marks == null) {
                    return `
                    <button   internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#full-width-modal">Create</button>
                    `
                } else {
                    return `
                    <button   internship_id='${data.id}' student_marks_id='${data.marks.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#full-width-modal">View</button>
                    <button internship_id='${data.id}' student_marks_id='${data.marks.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#danger-header-modal">Delete</button>

                `;
                }
            }
        },
    ];







onMounted(async () => {
    await getInternshipsIAccepted()
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">All Students</h4>
                        <router-link :to="{ name: 'allStudents' }" class="btn btn-dark btn-sm">View All Students</router-link>

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
    <FullWidthModal>
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Mark Information </h4>
                            <p class="text-muted font-14">
                                Manage Student Mark
                            </p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentStudentMarks.skills"
                                        :errorText="shared.getErrorText(errors, 'skills')"
                                        :showError="errors.hasOwnProperty('skills')" label="skills"
                                        inputType="number" placeholder="Enter Student skills" />
                                    <CustomInput v-model="currentStudentMarks.discipline"
                                        :errorText="shared.getErrorText(errors, 'discipline')"
                                        :showError="errors.hasOwnProperty('discipline')" label="Discipline"
                                        inputType="number" placeholder="Enter Student Discipline" />
                                    <CustomInput v-model="currentStudentMarks.initiative"
                                        :errorText="shared.getErrorText(errors, 'initiative')"
                                        :showError="errors.hasOwnProperty('initiative')" label="initiative"
                                        inputType="number" placeholder="Enter Student initiative" />

                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentStudentMarks.creativity"
                                        :errorText="shared.getErrorText(errors, 'creativity')"
                                        :showError="errors.hasOwnProperty('creativity')" label="creativity"
                                        inputType="number" placeholder="Enter Student creativity" />
                                    <CustomInput v-model="currentStudentMarks.knowledge"
                                        :errorText="shared.getErrorText(errors, 'knowledge')"
                                        :showError="errors.hasOwnProperty('knowledge')" label="knowledge"
                                        inputType="number" placeholder="Enter Student knowledge" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            <button type="button" @click="saveStudentMarks" class="btn btn-dark">Save</button>
        </template>
    </FullWidthModal>
    <DangerModalOutline>
        <template v-slot:body>
            Are you sure you want to delete marks of  <b>{{ currentInternship.student.first_name }} {{ currentInternship.student.last_name }} </b>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteMarks()" type="button" class="btn btn-danger">Delete</button>
        </template>
    </DangerModalOutline>

</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









