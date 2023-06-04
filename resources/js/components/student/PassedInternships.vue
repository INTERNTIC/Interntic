<script setup>
import { onMounted, ref } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';


import useInternshipRequest from '@/composables/InternshipRequests.js';
import { Notify, getErrorText } from "@/newShared";
import SelectInput from '../form/SelectInput.vue';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

const {
    getMyPassedInternships,
    passedInternships,
} = useInternshipRequest();

const if_null_show_none = value => value ?? "not set yet"

onMounted(async () => {
    await getMyPassedInternships()
});




</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">My Passed Internships</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="internship in passedInternships" :key="internship.id">
            <div class="card">
                <div class="card-body ">
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="header-title">{{ internship.theme }}</h4>
                            <p class="font-14 mb-1">from: <span class="text-muted"> {{ internship.start_at }}</span> to:
                                <span class="text-muted">{{ internship.end_at }}</span>
                            </p>
                            <p class="text-muted font-14 mb-1">Internship Boss Email : {{
                                internship.internshipResponsible_email
                            }} </p>
                            <p class="text-muted font-14 mb-1">Company : <b> {{ internship.company.name }}</b> , <b>
                                    {{ internship.company.location }}</b> </p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <h4 class="header-title">Marks</h4>
                                <div class="col-sm-6">
                                    <p class="font-14 mb-1">discipline: <span class="text-muted">{{
                                        if_null_show_none(internship.marks?.discipline) }}</span> </p>
                                    <p class="font-14 mb-1">skills: <span class="text-muted">{{
                                        if_null_show_none(internship.marks?.skills) }}</span> </p>
                                    <p class="font-14 mb-1">initiative: <span class="text-muted">{{
                                        if_null_show_none(internship.marks?.initiative) }}</span> </p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-14 mb-1">creativity: <span class="text-muted">{{
                                        if_null_show_none(internship.marks?.creativity) }}</span> </p>
                                    <p class="font-14 mb-1">knowledge: <span class="text-muted">{{
                                        if_null_show_none(internship.marks?.knowledge) }}</span> </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div>
                        <button type="button" @click="openEditModal(internship)" class="btn btn-warning me-2">Edit</button>
                        <button type="button" @click="openDeleteModal(internship.id)" class="btn btn-danger">Delete</button>

                    </div> -->
                </div> <!-- end card-body -->
            </div>
        </div>
    </div> <!-- end row-->
</template>









