<script setup>
import { onMounted, ref } from 'vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';
import CustomInput from '@/components/form/CustomInput.vue';
import UseAssessment from '@/composables/Assessment.js';


const {
    getStudentInternships,
    studentInternships,
} = UseAssessment();

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
const MarkExemple = {
    id: '',
    discipline: "",
    skills: "",
    initiative: "",
    creativity: "",
    knowledge: "",
    internship_request_id: "",
}
const currentInternship = ref(Object.create(internshipsExemple))
const currentMark = ref(Object.create(MarkExemple))



$(document).on('click', 'tr button', async (e) => {
    const internship_id = e.currentTarget.getAttribute('internship_id')
    currentInternship.value = studentInternships.value.find(internship => internship.id == internship_id);
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
                return ` 
                    <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#full-width-modal">View</button>
                    <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#evaluate-modal">Evaluate</button>
                    `;
            }
        },
    ];







onMounted(async () => {
    await getStudentInternships()
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
                        data: studentInternships.value,
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
                                        :readonly="true" label="Student Full Name" />
                                    <CustomInput :modelValue="currentInternship.student.student_card_number"
                                        :readonly="true" label="Student Student Card" />
                                    <CustomInput :modelValue="currentInternship.student.major" :readonly="true"
                                        label="Student Major" />
                                    <CustomInput :modelValue="currentInternship.student.email" :readonly="true"
                                        label="Student Email" />
                                    <CustomInput :modelValue="currentInternship.student.level" :readonly="true"
                                        label="Student Level" />
                                    <CustomInput :modelValue="currentInternship.theme" :readonly="true"
                                        label="Internship Theme" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentInternship.internshipResponsible_email"
                                        :readonly="true" label="Internship responsible email" />
                                    <CustomInput :modelValue="currentInternship.start_at" :readonly="true"
                                        label="Internship Start at" />
                                    <CustomInput :modelValue="currentInternship.end_at" :readonly="true"
                                        label="Internship End at" />
                                    <CustomInput :modelValue="currentInternship.company.name" :readonly="true"
                                        label="Internship Company Name" />
                                    <CustomInput :modelValue="currentInternship.company.location" :readonly="true"
                                        label="Internship Company Location" />

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
    <FullWidthModal modalId="#evaluate-modal">
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
                                    <CustomInput v-model="currentMark.discipline"
                                        :errorText="shared.getErrorText(errors, 'skills')"
                                        :showError="errors.hasOwnProperty('skills')" label="skills"
                                        placeholder="Enter Student skills" />
                                    <CustomInput v-model="currentMark.skills"
                                        :errorText="shared.getErrorText(errors, 'discipline')"
                                        :showError="errors.hasOwnProperty('discipline')" label="Discipline"
                                        placeholder="Enter Student Discipline" />
                                    <CustomInput v-model="currentMark.initiative"
                                        :errorText="shared.getErrorText(errors, 'initiative')"
                                        :showError="errors.hasOwnProperty('initiative')" label="initiative"
                                        placeholder="Enter Student initiative" />
                                
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentMark.creativity"
                                        :errorText="shared.getErrorText(errors, 'creativity')"
                                        :showError="errors.hasOwnProperty('creativity')" label="creativity"
                                        placeholder="Enter Student creativity" />
                                    <CustomInput v-model="currentMark.knowledge"
                                        :errorText="shared.getErrorText(errors, 'knowledge')"
                                        :showError="errors.hasOwnProperty('knowledge')" label="knowledge"
                                        placeholder="Enter Student knowledge" />
                                    <CustomInput v-model="currentMark.initiative"
                                        :errorText="shared.getErrorText(errors, 'initiative')"
                                        :showError="errors.hasOwnProperty('initiative')" label="initiative"
                                        placeholder="Enter Student initiative" />
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
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









