<script setup>
import { onMounted, ref } from 'vue';
import DangerModal from '../modal/DangerModal.vue';

import useDepartment from '@/composables/Department.js';
import { Notify, refreshTable, getErrorText } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";


const { get_departments,
    store_department,
    update_department,
    destroy_department,
    departments, } = useDepartment();
const department = {
    'id': '',
    "name": '',
    "short_cut": '',
}

const current_department = ref(_.cloneDeep(department))
let principleTable = null;

$(document).on('click', 'tr button', async (e) => {
    let department_id = e.currentTarget.getAttribute('department_id')
    let button_role = e.currentTarget.getAttribute('button-role')
    if (button_role == "edit") {
        window.scrollTo(0, 0);
    }
    if (department_id != undefined) {
        current_department.value = departments.value.find(st => st.id == department_id);
    }
});
const principleColumns =
    [
        { 'data': 'name' },
        { 'data': 'short_cut' },
        {
            data: null,
            render: function (data, type, row) {
                return ` <button   department_id='${data.id}'button-role="edit"  type="button" class="btn btn-warning btn-sm me-2" ><i class="mdi mdi-wrench"></i></button>
                        <button  button_type="delete" department_id='${data.id}' type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#fill-danger-modal"><i
                            class="mdi mdi-window-close"></i></button>`;
            }
        },
    ];



const save_department = async () => {

    if (current_department.value.id == "") {
        await store_department(current_department.value)
    } else {
        await update_department(current_department.value.id, current_department.value)
    }
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        await get_departments();
        refreshTable(principleTable, departments.value)
        current_department.value = _.cloneDeep(department)
    }
}
const delete_department = async (department) => {
    await destroy_department(department.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        await get_departments()
        refreshTable(principleTable, departments.value)
    }
    current_department.value = _.cloneDeep(department)
}


onMounted(async () => {
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
                        data: departments.value,
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
                        <li class="breadcrumb-item active">Manage departments </li>
                    </ol>
                </div>
                <h4 class="page-title">Manage departments</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">department Information</h4>
                    <p class="text-muted font-14">
                        Add a New Department
                    </p>

                    <form class="row">
                        <div class="col-lg-6">
                            <FloatingInput v-model="current_department.name"
                                :errorText="getErrorText(errors, 'name')"
                                :showError="errors.hasOwnProperty('name')" label="Name"
                                placeholder="Enter Name" />
                        </div>
                        <div class="col-lg-6">
                            <FloatingInput v-model="current_department.short_cut"
                                :errorText="getErrorText(errors, 'short_cut')"
                                :showError="errors.hasOwnProperty('short_cut')" label="Short Cut"
                                placeholder="Enter Short Cut" />
                        </div>
                    </form>

                    <div>
                        <button @click="save_department" class="btn btn-primary">Submit</button>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All departments</h4>
                    <p class="text-muted font-14">
                        Here is a list of all departments in the University
                    </p>

                    <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                        <thead>
                            <tr>
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


    <DangerModal modal_heading="Delete department">
        <template v-slot:body>
            Are you sure you want to delete department <b>{{ current_department.first_name }} {{
                current_department.last_name }} </b>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="delete_department(current_department)" type="button" class="btn btn-outline-light"
                data-bs-dismiss="modal">Delete</button> </template>
    </DangerModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>







