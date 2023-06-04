<script setup>
import { onMounted, ref } from 'vue';


import useInternshipResponsibleAccount from '@/composables/InternshipResponsibleAccount.js';
import {Notify,getErrorText,refreshTable} from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

import { useLoading } from 'vue-loading-overlay'

const $loading = useLoading({
});
const decision=ref({
    'decision':''
})
const {
    getInternshipResponsibleAccounts,
    manageInternshipResponsibleAccount,
    internshipResponsibleAccounts,
 } = useInternshipResponsibleAccount();
const AccountRequestExemple = {
    "id": "",
    "email": "",
    "phone": ""
}
const currentAccountRequest = ref(AccountRequestExemple)
let principleTable = null;


$(document).on('click', 'tr button', async (e) => {

    let button = e.currentTarget.getAttribute('button-type')
    const account_request_id = e.currentTarget.getAttribute('account_request_id')
    decision.value.decision=button
    switch (button) {
        case 'view':
            currentAccountRequest.value = internshipResponsibleAccounts.value.find(requst => requst.id == account_request_id);
            break;
        case 'accept':
        case 'refuse':
            await manageInternshipResponsibleAccount(decision.value, account_request_id)
            Notify(generalSuccessMsg.value,generalErrorMsg.value)
            await getInternshipResponsibleAccounts()
            refreshTable(principleTable,internshipResponsibleAccounts.value)
            break;
    }
    button=null;
});
const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.first_name + "  " + row.last_name;
            }
        },
        { 'data': 'company.name' },
        { 'data': 'company.location' },
        {
            data: null,
            render: function (data, type, row) {
                return `<button button-type="view"  account_request_id='${data.id}'  type="button" class="btn btn-dark btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">View</button>
                        <button button-type="accept"  account_request_id='${data.id}'  type="button" class="btn btn-success btn-sm me-2" >Accept</button>
                        <button button-type="refuse"  account_request_id='${data.id}'  type="button" class="btn btn-danger btn-sm me-2" >Refuse</button>
                        `;
            }
        },
    ];







onMounted(async () => {
    await getInternshipResponsibleAccounts()
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
                        data: internshipResponsibleAccounts.value,
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
                        <li class="breadcrumb-item active">Manage Internship Responsible Accounts</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Requested Accounts</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All Requested Accounts</h4>
                    <p class="text-muted font-14">
                        Here is a list of all requested accounts
                    </p>

                    <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Company Name</th>
                                <th>Company Location</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                    </table>
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
                            <h4 class="header-title">Internship Responsible Account</h4>
                            <p class="text-muted font-14">
                                Manage Account Request
                            </p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentAccountRequest.email" :readonly="true" label="Email"
                                        inputType="text" />
                                </div>
                                <div class="col-lg-6">
                                    <CustomInput :modelValue="currentAccountRequest.phone" :readonly="true" label="Phone"
                                        inputType="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </template>
    </FullWidthModal>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









