<script setup>
import { onBeforeMount, onMounted, ref, watch } from 'vue';
import DangerModal from '../modal/DangerModal.vue';
import FullWidthModal from '@/components/modal/FullWidthModal.vue';

import useManageStudent from '@/composables/ManageStudent.js';
import StudentModelForm from './StudentModelForm.vue';
import shared from "@/shared";
const { getStudents, storeStudent, destroyStudent, updateStudent, students, getMajorsOfLevel, getLevels, levels, majors, generalErrorMsg, generalSuccessMsg, editErrors, errors } = useManageStudent();
const studentExemple = {
    first_name: "",
    last_name: "",
    student_card_number: "",
    birthday: "",
    place_of_birth: "",
    phone_number: "",
    social_security_num: "",
    level_id: "",
    major_id: "",
}
const defultStudentExemple = {
    first_name: "",
    last_name: "",
    student_card_number: "",
    birthday: "",
    place_of_birth: "",
    phone_number: "",
    social_security_num: "",
    level_id: "",
    major_id: "",
}

const currentStudent = ref({ ...studentExemple, ...{ "id": "" } })
const studentModel = ref(studentExemple)
let principleTable = null;
let secondaryTable = null;

const isSecondaryTableActive = ref(false)
$(document).on('click', 'tr button', async (e) => {
    let student_id = e.currentTarget.getAttribute('student_id')
    if(student_id!=undefined) {
       currentStudent.value = students.value.find(st => st.id == student_id);
        await getMajorsOfLevel(currentStudent.value.level_id )
    }
});
const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.first_name + "  " + row.last_name;
            }
        },
        { 'data': 'student_card_number' },
        { 'data': 'major' },
        { 'data': 'level' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button   student_id='${data.id}'  type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal"><i class="mdi mdi-wrench"></i></button>
                        <button  button_type="delete" student_id='${data.id}' type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#fill-danger-modal"><i
                            class="mdi mdi-window-close"></i></button>`;
            }
        },
    ];
const secondaryColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.first_name + "  " + row.last_name;
            }
        },
        { 'data': 'phone_number' },
        { 'data': 'social_security_num' },
        { 'data': 'birthday' },
        { 'data': 'place_of_birth' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button  student_id='${data.id}'  type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal"><i class="mdi mdi-wrench"></i></button>
                        <button  student_id='${data.id}' type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#fill-danger-modal"><i
                            class="mdi mdi-window-close"></i></button>`;
            }
        },
    ];


watch(
    () => studentModel.value.level_id, () => {
        // $("select").val($("select option:first").val());
        if (studentModel.value.level_id != '') {
            console.log('student level change');
            console.log(studentModel.value.level_id);
            getMajorsOfLevel(studentModel.value.level_id)
        }
    },
)
watch(
    () => currentStudent.value.level_id, () => {
        // $("select").val($("select option:first").val());
        if (currentStudent.value.level_id != '') {
            getMajorsOfLevel(currentStudent.value.level_id)
        }
    },
)

const addStudent = async () => {

    await storeStudent(studentModel.value)
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudents();
        shared.refreshTable(principleTable, students.value)
        if (isSecondaryTableActive.value) {
            shared.refreshTable(secondaryTable, students.value)
        }
        Object.assign(studentModel.value, defultStudentExemple);
        $('form').trigger("reset");

    }

}

const saveStudent = async () => {
    await updateStudent(currentStudent.value)
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudents()
        shared.refreshTable(principleTable, students.value)
        if (isSecondaryTableActive.value) {
            shared.refreshTable(secondaryTable, students.value)
        }
        $('#full-width-modal').modal('hide')
    }
}
const deleteStudent = async (student) => {
    await destroyStudent(student.id)
    shared.Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudents()
        shared.refreshTable(principleTable, students.value)
        if (isSecondaryTableActive.value) {
            shared.refreshTable(secondaryTable, students.value)
        }
    }
    Object.assign(currentStudent.value, defultStudentExemple);
}


onMounted(async () => {
    await getStudents()
    await getLevels()
    import('@/assets/js/vendor/jquery.dataTables.min.js').then(() => {
    import('@/assets/js/vendor/dataTables.bootstrap5.js').then(() => {
        import('@/assets/js/vendor/dataTables.responsive.min.js').then(() => {
            import('@/assets/js/vendor/responsive.bootstrap5.min.js').then(() => {
                    console.log('nothing3');
                    // import('@/assets/js/pages/demo.datatable-init.js').then(() => {


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
                        data: students.value,
                        columns: principleColumns
                    });
                    secondaryTable = $("#example").DataTable({
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
                        data: students.value,
                        columns: secondaryColumns
                    });
                    // });
                });
            });
        });
    });
});

const showSecondaryTable = (TableStatus) => {
    if (TableStatus) {
        shared.refreshTable(secondaryTable, students.value)
    }
    isSecondaryTableActive.value = TableStatus
}



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
                    <h4 class="header-title">Student Information</h4>
                    <p class="text-muted font-14">
                        Add a New Student
                    </p>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="floating-preview">
                            <StudentModelForm v-bind:studentModel="studentModel" :errors="errors" :majors="majors"
                                :levels="levels" />
                            <div>
                                <button @click="addStudent()" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->


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
                            <a @click="showSecondaryTable(false)" href="#basic-datatable-preview" data-bs-toggle="tab"
                                aria-expanded="false" class="nav-link active">
                                Preview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a @click="showSecondaryTable(true)" href="#basic-example-code" data-bs-toggle="tab"
                                aria-expanded="true" class="nav-link">
                                Code
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
                        <div class="tab-pane" id="basic-example-code">
                            <table id="example" class="table table-hover  table-bordered w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Social Security Number</th>
                                        <th>Birthday</th>
                                        <th>Place of Birth</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- end preview-->
                    </div>
                    <!-- end tab-content-->

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
                            <h4 class="header-title">Student Information</h4>
                            <p class="text-muted font-14">
                                Edit Student Information
                            </p>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="floating-preview">
                                    <StudentModelForm v-bind:studentModel="currentStudent" :errors="editErrors"
                                        :majors="majors" :levels="levels" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" @click="saveStudent" class="btn btn-info">Save changes</button>
        </template>
    </FullWidthModal>


   
    <DangerModal>
        <template v-slot:body>
            Are you sure you want to delete student <b>{{ currentStudent.first_name }} {{ currentStudent.last_name }} </b>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteStudent(currentStudent)" type="button" class="btn btn-outline-light"
                data-bs-dismiss="modal">Delete</button> </template>
    </DangerModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>
<!-- @import 'datatables.net-dt';
@import 'datatables.net-select-dt'; -->
<!-- #basic-datatable_filter input[type='search'],
#basic-datatable_length select {
    width: auto !important;
    display: unset !important;
} -->








