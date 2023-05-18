<script setup>
import { onMounted, ref } from 'vue';
import InfoModalOutline from '@/components/modal/InfoModalOutline.vue';


import useInternshipRequest from '@/composables/InternshipRequests.js';
import useGneratePdf from '@/composables/GneratePdf.js';
import {useLoading} from 'vue-loading-overlay';
import {Notify} from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const $loading = useLoading({});
const { getInternshipsAcceptedByInternshipResponsible, getInternshipsAcceptedByStudent, internshipsAcceptedByInternshipResponsible, studentsRequests } = useInternshipRequest()
const { downloadPdf } = useGneratePdf()
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
        phone: '',
        student_card: '',
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
    marks: {
        discipline: "",
        skills: "",
        initiative: "",
        creativity: "",
        knowledge: "",
    }
}
const currentInternship = ref(Object.create(internshipsExemple))
let principleTable = null;



$(document).on('click', 'tr button', async (e) => {
    const internship_id = e.currentTarget.getAttribute('internship_id')
    const arrayConcat = [].concat(studentsRequests.value, internshipsAcceptedByInternshipResponsible.value);
    currentInternship.value = arrayConcat.find(internship => internship.id == internship_id);
});

const getPdf = async () => {
    const loader = $loading.show({color: 'green'});
    await downloadPdf(currentInternship.value.id)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        $('#document-modal').modal('hide')
        currentInternship.value=_.cloneDeep(internshipsExemple)
    }
    loader.hide();


}

const principleColumns =
    [
        {
            'data': 'null', render: function (data, type, row) {
                return row.student.first_name + "  " + row.student.last_name;
            }
        },
        { 'data': 'student.student_card' },
        {
            'data': 'null', render: function (data, type, row) {
                const str=row.textStatus.replace(/_/g, " ");
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        },
        { 'data': 'student.level' },
        { 'data': 'student.level' },
        {
            data: null,
            render: function (data, type, row) {
                if (data.status == 5) {
                    return ` 
                        <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">View</button>
    
                        <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#mark-modal">Marks</button>
                        <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#document-modal">Print Documents</button>
                        `;
                } else {
                    return ` 
                        <button internship_id='${data.id}'  type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">View</button>
                        `;

                }
            }
        },
    ];







onMounted(async () => {
    await getInternshipsAcceptedByInternshipResponsible()
    await getInternshipsAcceptedByStudent()
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
                        data: [].concat(studentsRequests.value, internshipsAcceptedByInternshipResponsible.value),
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
                        <li class="breadcrumb-item active"> Students </li>
                    </ol>
                </div>
                <h4 class="page-title">Students</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All Students</h4>
                    <p class="text-muted font-14">
                        Here is a list of all students that internship responsible accepted their request
                    </p>

                    <table id="scroll-horizontal-datatable" class="table table-hover  table-bordered w-100 nowrap ">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Card Number</th>
                                <th>Status</th>
                                <th>Major</th>
                                <th>Level</th>
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
                            <h4 class="header-title">Internship Information </h4>
                            <p class="text-muted font-14">
                                Manage Student Internship
                            </p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <CustomInput
                                        :modelValue="`${currentInternship.student.first_name} ${currentInternship.student.last_name}`"
                                        :readonly="true" label="Student Full Name" />
                                    <CustomInput :modelValue="currentInternship.student.student_card" :readonly="true"
                                        label="Student Student Card" />
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

    <FullWidthModal modalId="mark-modal" v-if="currentInternship.marks">
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
                                    <CustomInput v-model="currentInternship.marks.skills" :readonly="true" label="skills"
                                        inputType="number" placeholder="Student skills" />
                                    <CustomInput v-model="currentInternship.marks.discipline" :readonly="true"
                                        label="Discipline" inputType="number" placeholder="Student Discipline" />
                                    <CustomInput v-model="currentInternship.marks.initiative" :readonly="true"
                                        label="initiative" inputType="number" placeholder="Student initiative" />

                                </div>
                                <div class="col-lg-6">
                                    <CustomInput v-model="currentInternship.marks.creativity" :readonly="true"
                                        label="creativity" inputType="number" placeholder="Student creativity" />
                                    <CustomInput v-model="currentInternship.marks.knowledge" :readonly="true"
                                        label="knowledge" inputType="number" placeholder="Student knowledge" />
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
    <InfoModalOutline modalId="document-modal" modal_heading="Document Print" v-if="currentInternship.marks">
        <template v-slot:body>

            <button  type="button" @click="getPdf()" class="btn btn-dark">Get Certeficate</button>

        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </template>
    </InfoModalOutline>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









