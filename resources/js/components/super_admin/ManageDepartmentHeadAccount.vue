<script setup>
import { onMounted, ref, watch } from 'vue';
import DangerModal from '../modal/DangerModal.vue';


import use_department_head from '@/composables/DepartmentHead.js';
import useDepartment from '@/composables/Department.js';
import { Notify, refreshTable, getErrorText } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
import CustomPasswordInput from '../form/CustomPasswordInput.vue';
const { get_department_heads,
    store_department_head,
    update_department_head,
    destroy_department_head,
    department_heads, } = use_department_head();
const { get_departments,
    departments, } = useDepartment();
const department_head = {
    'id': '',
    'first_name': '',
    'last_name': '',
    'email': '',
    'password': '',
    'password_confirmation': '',
    'department_id': '',
    "department": {
        "name": '',
        "short_cut": '',
    }
}

const current_department_head = ref(_.cloneDeep(department_head))
const is_current_department_head_edited = ref(false)
let principleTable = null;

$(document).on('click', 'tr button', async (e) => {
    let department_head_id = e.currentTarget.getAttribute('department_head_id')
    let button_role = e.currentTarget.getAttribute('button-role')
    if (button_role == "edit") {
        is_current_department_head_edited.value = true;
        window.scrollTo(0, 0);
    }
    if (department_head_id != undefined) {
        current_department_head.value = department_heads.value.find(st => st.id == department_head_id);
    }
});
const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.first_name + "  " + row.last_name;
            }
        },
        { 'data': 'email' },
        { 'data': 'department.name' },
        { 'data': 'department.short_cut' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button   department_head_id='${data.id}'button-role="edit"  type="button" class="btn btn-warning btn-sm me-2" ><i class="mdi mdi-wrench"></i></button>
                        <button  button_type="delete" department_head_id='${data.id}' type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#fill-danger-modal"><i
                            class="mdi mdi-window-close"></i></button>`;
            }
        },
    ];



const save_department_head = async () => {

    if (current_department_head.value.id == "") {
        await store_department_head(current_department_head.value)
    } else {
        await update_department_head(current_department_head.value.id,current_department_head.value)
    }
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        await get_department_heads();
        refreshTable(principleTable, department_heads.value)
        is_current_department_head_edited.value = false;
        current_department_head.value = _.cloneDeep(department_head)
    }
}
const delete_department_head = async (department_head) => {
    await destroy_department_head(department_head.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await get_department_heads()
        refreshTable(principleTable, department_heads.value)
    }
    current_department_head.value = _.cloneDeep(department_head)
}


onMounted(async () => {
    await get_department_heads()
    await get_departments()
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
                        data: department_heads.value,
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
                        <li class="breadcrumb-item active">Manage Department heads Accounts</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Department Heads</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">department head Information</h4>
                    <p class="text-muted font-14">
                        Add a New department_head
                    </p>

                    <form class="row">
                        <div class="col-lg-6">
                            <FloatingInput v-model="current_department_head.first_name"
                                :errorText="getErrorText(errors, 'first_name')"
                                :showError="errors.hasOwnProperty('first_name')" label="First Name"
                                placeholder="Enter First Name" />
                        </div>
                        <div class="col-lg-6">
                            <FloatingInput v-model="current_department_head.last_name"
                                :errorText="getErrorText(errors, 'last_name')"
                                :showError="errors.hasOwnProperty('last_name')" label="Last Name"
                                placeholder="Enter Last Name" />
                        </div>
                        <div class="col-lg-6">
                            <FloatingInput v-model="current_department_head.email"
                                :errorText="getErrorText(errors, 'email')" :showError="errors.hasOwnProperty('email')"
                                label="Department Head Email" placeholder="Enter Department Head Email" />
                        </div>

                        <div class="col-lg-6 ">
                            <SelectInput propertyOfValue="id" property-of-show="name" placeholder="Select Department"
                                :floatingTheme="true" v-model="current_department_head.department_id"
                                :errorText="getErrorText(errors, 'department_id')"
                                :showError="errors.hasOwnProperty('department_id')" label="Select Department"
                                :options="departments">
                            </SelectInput>
                        </div>
                        <template v-if="!is_current_department_head_edited">

                            <div class="col-lg-6 ">
                                <CustomPasswordInput v-model="current_department_head.password"
                                    :errorText="getErrorText(errors, 'password')" placeholder="Enter Passord Again"
                                    label="Password" :showError="errors.hasOwnProperty('password')" />
                            </div>
                            <div class="col-lg-6 ">
                                <CustomPasswordInput v-model="current_department_head.password_confirmation"
                                    :errorText="getErrorText(errors, 'password_confirmation')"
                                    placeholder="Enter a Strong Password" label="Confirm Password"
                                    :showError="errors.hasOwnProperty('password_confirmation')" />

                            </div>
                        </template>
                    </form>

                    <div>
                        <button @click="save_department_head" class="btn btn-primary">Submit</button>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All department heads</h4>
                    <p class="text-muted font-14">
                        Here is a list of all department_heads in the University
                    </p>

                    <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Department name</th>
                                <th>Department short cut</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->


    <DangerModal modal_heading="Delete Department Head">
        <template v-slot:body>
            Are you sure you want to delete department_head <b>{{ current_department_head.first_name }} {{
                current_department_head.last_name }} </b>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="delete_department_head(current_department_head)" type="button" class="btn btn-outline-light"
                data-bs-dismiss="modal">Delete</button> </template>
    </DangerModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>








