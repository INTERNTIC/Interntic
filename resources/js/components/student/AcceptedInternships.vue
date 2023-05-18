<script setup>
import { onMounted } from 'vue';
import useInternshipRequest from '@/composables/InternshipRequests.js';


const {
    getInternshipsAcceptedByDepartmentHead,
    getInternshipsAcceptedByInternshipResponsible,
    internshipsAcceptedByDepartmentHead,
    internshipsAcceptedByInternshipResponsible,
} = useInternshipRequest();



onMounted(async () => {
    await getInternshipsAcceptedByInternshipResponsible();
    await getInternshipsAcceptedByDepartmentHead();
    
});




</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Accepted Internships</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="internship in internshipsAcceptedByDepartmentHead" :key="internship.id" class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ internship.theme }}</h4>
                    <p class="font-14">from: <span class="text-muted"> {{ internship.start_at }}</span> to: <span
                            class="text-muted">{{ internship.end_at }}</span> </p>
                    <p class="text-muted font-14">Status : {{ internship.textStatus }} </p>
                    <p class="text-muted font-14">Internship Boss Email : {{ internship.internshipResponsible_email }} </p>
                    <p class="text-muted font-14">Company : <b> {{ internship.company.name }}</b> , <b>
                            {{ internship.company.location }}</b> </p>

                </div> <!-- end card-body -->
            </div>
        </div>
        <div v-for="internship in internshipsAcceptedByInternshipResponsible" :key="internship.id" class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ internship.theme }}</h4>
                    <p class="font-14">from: <span class="text-muted"> {{ internship.start_at }}</span> to: <span
                            class="text-muted">{{ internship.end_at }}</span> </p>
                            <p class="text-muted font-14">Status : {{ internship.textStatus }} </p>
                    <p class="text-muted font-14">Internship Boss Email : {{ internship.internshipResponsible_email }} </p>
                    <p class="text-muted font-14">Company : <b> {{ internship.company.name }}</b> , <b>
                            {{ internship.company.location }}</b> </p>

                </div> <!-- end card-body -->
            </div>
        </div>
    </div>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









