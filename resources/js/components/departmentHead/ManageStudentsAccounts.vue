<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModal from '../modal/DangerModal.vue';


import useStudent from '@/composables/Student.js';
import StudentModelForm from './StudentModelForm.vue';
import { Notify, refreshTable } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

const { getStudents, storeStudent, destroyStudent,
    updateStudent, students, getMajorsOfLevel,
    getLevels, levels, majors } = useStudent();
const student = {
    id: "",
    first_name: "",
    last_name: "",
    student_card: "",
    birthday: "",
    place_of_birth: "",
    phone: "",
    social_security_num: "",
    level_id: "",
    major_id: "",
}

const currentStudent = ref(_.cloneDeep(student))
let principleTable = null;
let secondaryTable = null;

const isSecondaryTableActive = ref(false)
$(document).on('click', 'tr button', async (e) => {
    let student_id = e.currentTarget.getAttribute('student_id')
    let button_role = e.currentTarget.getAttribute('button-role')
    if (button_role == "edit") {
        window.scrollTo(0, 0);
    }
    if (student_id != undefined) {
        currentStudent.value = students.value.find(st => st.id == student_id);
        await getMajorsOfLevel(currentStudent.value.level_id)
    }
});
const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.first_name + "  " + row.last_name;
            }
        },
        { 'data': 'student_card' },
        { 'data': 'major' },
        { 'data': 'level' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button   student_id='${data.id}'button-role="edit"  type="button" class="btn btn-warning btn-sm me-2" ><i class="mdi mdi-wrench"></i></button>
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
        { 'data': 'phone' },
        { 'data': 'social_security_num' },
        { 'data': 'birthday' },
        { 'data': 'place_of_birth' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button student_id='${data.id}' button-role="edit"  type="button" class="btn btn-warning btn-sm me-2" ><i class="mdi mdi-wrench"></i></button>
                        <button  student_id='${data.id}' type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#fill-danger-modal"><i
                            class="mdi mdi-window-close"></i></button>`;
            }
        },
    ];


watch(
    () => currentStudent.value.level_id, () => {
        // $("select").val($("select option:first").val());
        if (currentStudent.value?.level_id != '') {
            getMajorsOfLevel(currentStudent.value.level_id)
        }
    },
)

const saveStudent = async () => {

    if (currentStudent.value.id == "") {
        await storeStudent(currentStudent.value)
    } else {
        await updateStudent(currentStudent.value)
    }
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudents();
        refreshTable(principleTable, students.value)
        if (isSecondaryTableActive.value) {
            refreshTable(secondaryTable, students.value)
        }
        currentStudent.value = _.cloneDeep(student)
    }

}
const deleteStudent = async (student) => {
    await destroyStudent(student.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await getStudents()
        refreshTable(principleTable, students.value)
        if (isSecondaryTableActive.value) {
            refreshTable(secondaryTable, students.value)
        }
    }
    currentStudent.value = _.cloneDeep(student)
}


onMounted(async () => {
    await getStudents()
    await getLevels()
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
                    get_table_back()
                });
            });
        });
    });
});

const showSecondaryTable = (TableStatus) => {
    if (TableStatus) {
        refreshTable(secondaryTable, students.value)
    }
    isSecondaryTableActive.value = TableStatus
}

const table_status = ref(false)
const get_table_back = () => {
    setTimeout(() => {
        table_status.value = true;
    }, 500);
    return true;
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
                            <StudentModelForm v-bind:studentModel="currentStudent" :errors="errors" :majors="majors"
                                :levels="levels" />
                            <div>
                                <button @click="saveStudent" type="submit" class="btn btn-primary">Submit</button>
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
                                Simple
                            </a>
                        </li>
                        <li class="nav-item">
                            <a @click="showSecondaryTable(true)" href="#basic-example-code" data-bs-toggle="tab"
                                aria-expanded="true" class="nav-link">
                                Details
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" :class="{ 'd-none': !table_status }" id="basic-datatable-preview">
                            <table id="scroll-horizontal-datatable" class="table table-hover table-bordered w-100 nowrap ">
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
                        <div class="tab-pane" :class="{ 'd-none': !table_status }" id="basic-example-code">
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
    <DangerModal modal_heading="Delete Student">
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








