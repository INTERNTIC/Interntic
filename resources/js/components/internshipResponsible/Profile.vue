<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/AuthStore';
import { getErrorText,Notify } from "@/newShared";
import { computed } from 'vue';

import useInternshipResponsible from '@/composables/InternshipResponsible.js';
import {updateCompany} from '@/composables/Company.js';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {
    updateInternshipResponsible,
} = useInternshipResponsible();

const authStore = useAuthStore();

const currentInternshipResponsible = ref(authStore.authUser);

const full_name = computed(() => {
    return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})


const saveInternshipResponsible = async () => {
    await updateInternshipResponsible(currentInternshipResponsible.value.id,currentInternshipResponsible.value)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
}

const saveCompany = async () => {
    await updateCompany(currentInternshipResponsible.value.company.id,currentInternshipResponsible.value.company)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
}

</script>
<template>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">Seeting</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="assets/images/users/internship_responsible.png" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">

                    <h4 class="mb-0 mt-2">{{full_name}}</h4>
                    <p class="text-muted font-14">{{authStore.userGuard}}</p>


                    <div class="text-start mt-3">

                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{ full_name
                        }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{
                            authStore.authUser.phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{
                            authStore.authUser.email }}</span></p>

                        
                            <p class="text-muted mb-2 font-13"><strong>Company Name :</strong><span class="ms-2">{{
                                authStore.authUser.company.name }}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>Company Location :</strong> <span class="ms-2 ">{{
                                authStore.authUser.company.location }}</span></p>
                    </div>


                </div> <!-- end card-body -->
            </div> <!-- end card -->


        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">

                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link rounded-0 active">
                                Settings
                            </a>
                        </li>
                       
                            <li class="nav-item">
                                <a href="#company" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                    Company
                                </a>
                            </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                           
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info
                                </h5>
                                <div class="row">
                                  
                                    <CustomInput v-model="currentInternshipResponsible.first_name" :errorText="getErrorText(errors, 'first_name')"
                                        :showError="errors.hasOwnProperty('first_name')" label="Enter First Name" 
                                        placeholder="Your First Name" />
                                    <CustomInput v-model="currentInternshipResponsible.last_name" :errorText="getErrorText(errors, 'last_name')"
                                        :showError="errors.hasOwnProperty('last_name')" label="Enter last Name" 
                                        placeholder="Your Last name" />
                                    <CustomInput v-model="currentInternshipResponsible.email" :errorText="getErrorText(errors, 'email')"
                                        :showError="errors.hasOwnProperty('email')" label="Enter email" 
                                        placeholder="Your email" />
                                    <CustomInput v-model="currentInternshipResponsible.phone" :errorText="getErrorText(errors, 'phone')"
                                        :showError="errors.hasOwnProperty('phone')" label="Enter Phone" input-type="number"
                                        placeholder="Your Phone" />

                                  
                                </div> <!-- end row -->
                               


                                <div class="text-end">
                                    <button @click="saveInternshipResponsible" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i>Update</button>
                                </div>
                            
                        </div>
                        
                            <div class="tab-pane" id="company">
                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i>
                                    Company Info</h5>
                                <div class="row">
                                    <CustomInput v-model="currentInternshipResponsible.company.name" :errorText="getErrorText(errors, 'name')"
                                        :showError="errors.hasOwnProperty('name')" label="Enter name"
                                        placeholder="Your name" />
                                    <CustomInput v-model="currentInternshipResponsible.company.location" :errorText="getErrorText(errors, 'location')"
                                        :showError="errors.hasOwnProperty('location')" label="Enter location"
                                        placeholder="Your location" />

                                </div>
                                <div class="text-end">
                                    <button @click="saveCompany" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i>Update</button>
                                </div>
                            </div>
                       
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
</template>
<style></style>









