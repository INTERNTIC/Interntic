<script setup>
import { onMounted } from 'vue';
import useInternshipRequest from '@/composables/InternshipRequests.js';
import { useLoading } from 'vue-loading-overlay';
import { Notify } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {
    getInternshipsAcceptedByDepartmentHead,
    getInternshipsAcceptedByInternshipResponsible,
    internshipsAcceptedByDepartmentHead,
    internshipsAcceptedByInternshipResponsible,
    accept_internship,
    destroyInternshipRequest
} = useInternshipRequest();

const $loading = useLoading({
});


onMounted(async () => {
    await getInternshipsAcceptedByInternshipResponsible();
    await getInternshipsAcceptedByDepartmentHead();

});

const accept_my_internship = async (_internship_id) => {
    const loader = $loading.show({
        color: 'green',
    });
    await accept_internship(_internship_id);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getInternshipsAcceptedByInternshipResponsible();
        await getInternshipsAcceptedByDepartmentHead();
    }
    loader.hide();
}
const delete_my_internship = async (_internship_id) => {
    const loader = $loading.show({
        color: 'green',
    });
    await destroyInternshipRequest(_internship_id);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getInternshipsAcceptedByInternshipResponsible();
        await getInternshipsAcceptedByDepartmentHead();
    }
    loader.hide();
}


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
                    <div>
                        <button @click="delete_my_internship(internship.id)" type="button"
                            class="btn btn-danger">Delete</button>
                    </div>
                </div>
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

                    <div>
                        <button @click="delete_my_internship(internship.id)" type="button"
                            class="btn btn-danger">Delete</button>
                        <button @click="accept_my_internship(internship.id)" type="button"
                            class="btn btn-warning ms-2">Validate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
@import "@/assets/css/vendor/dataTables.bootstrap5.css";
@import "@/assets/css/vendor/responsive.bootstrap5.css";
</style>









