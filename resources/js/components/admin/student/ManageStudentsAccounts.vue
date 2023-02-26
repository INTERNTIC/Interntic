<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModal from '../../modal/DangerModal.vue';
import FullWidthModal from '../../modal/FullWidthModal.vue';
import useManageStudent from '@/composables/ManageStudent.js';


import StudentModelForm from './StudentModelForm.vue';
const currentStudent = ref({
    first_name: "lokman",
    last_name: "abd",
    student_card_number: "",
    birthday: "",
    place_of_birth: "",
    phone_number: "",
    social_security_num: "",
    level_id: "",
    major_id: "",
})
const { addStudent, deleteStudent, editStudent, students, getMajors, levels, majors, generalErrorMsg,editErrors, errors } = useManageStudent();
const studentModel = ref({
    first_name: "",
    last_name: "",
    student_card_number: "",
    birthday: "",
    place_of_birth: "",
    phone_number: "",
    social_security_num: "",
    level_id: "",
    major_id: "",
})
watch(
    () => studentModel.value.level_id, () => {
        console.log('student level change');
        getMajors()
    }
)

const table = [
    () => import("@/assets/js/vendor/jquery.dataTables.min.js"),
    () => import("@/assets/js/vendor/dataTables.bootstrap5.js"),
    () => import("@/assets/js/vendor/dataTables.responsive.min.js"),
    () => import("@/assets/js/pages/demo.datatable-init.js"),
]
onMounted(() => {
    table.forEach(jsFiles => {
        jsFiles()
    });
})
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
                            <StudentModelForm
                            v-bind:studentModel="studentModel"
                            :errors="errors"
                            :majors="majors"
                            :levels="levels"
                            />
                            <div>
                                <button @click="addStudent(studentModel)" type="submit" class="btn btn-primary">Submit</button>
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
                            <a href="#basic-datatable-preview" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link active">
                                Preview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#basic-example-code" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Code
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-datatable-preview">
                            <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Card Number</th>
                                        <th>Major</th>
                                        <th>Level</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td class="table-action">
                                            <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                                data-bs-target="#full-width-modal"><i class="mdi mdi-wrench"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                                                data-bs-target="#fill-danger-modal"><i
                                                    class="mdi mdi-window-close"></i></button>
                                            <!-- <div role="button" class="action-icon " > <i
                                                        class="mdi mdi-pencil edit-icon-color"></i></div>
                                                <div  role="button" class="action-icon"  data-bs-toggle="modal" data-bs-target="#fill-danger-modal">
                                                    <i class="mdi mdi-delete delete-icon-color"></i></div> -->
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="basic-example-code">
                            <table class="table w-100 nowrap scroll-horizontal-datatable">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Social Security Number</th>
                                        <th>Birthday</th>
                                        <th>Place of Birth</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                    </tr>
                                </tbody>
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
    <FullWidthModal
    v-bind:buttonEvent="editStudent"
    :changedObject="currentStudent">
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
                                <StudentModelForm
                                v-bind:studentModel="currentStudent"
                                :errors="editErrors"
                                :majors="majors"
                                :levels="levels"
                                />
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

    </FullWidthModal>
    
    <!-- /.modal -->
    <!-- Danger Filled Modal -->
    <DangerModal :deleteEvent="deleteStudent" :deletedObject="currentStudent"
        deleteMsg="Are you sure you want to delete student" firstProperty="first_name" secondProperty="last_name" />
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";

#basic-datatable_filter input[type='search'],
#basic-datatable_length select {
    width: auto !important;
    display: unset !important;
}
</style>

