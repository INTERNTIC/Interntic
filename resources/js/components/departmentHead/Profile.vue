<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/AuthStore';
import { getErrorText,Notify } from "@/newShared";
import { computed } from 'vue';

import useDepartmentHead from '@/composables/DepartmentHead.js';
import useDepartment from '@/composables/Department.js';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {
    updateDepartment,
} = useDepartment();
const {
    updateDepartmentHead,
} = useDepartmentHead();

const authStore = useAuthStore();

const currentDepartmentHead = ref(authStore.authUser);

const full_name = computed(() => {
    return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})

const saveDepartmentHead = async () => {
    await updateDepartmentHead(currentDepartmentHead.value.id,currentDepartmentHead.value)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
}

const saveDepartment = async () => {
    await updateDepartment(currentDepartmentHead.value.department.id,currentDepartmentHead.value.department)
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
                    <img src="assets/images/users/avatar-1.jpg" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">

                    <h4 class="mb-0 mt-2">{{full_name}}</h4>
                    <p class="text-muted font-14">{{authStore.userGuard}}</p>


                    <div class="text-start mt-3">

                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{ full_name}}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{
                            authStore.authUser.email }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Department Name :</strong><span class="ms-2">{{
                            authStore.authUser.department.name }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Department Short Cut :</strong> <span class="ms-2 ">{{
                            authStore.authUser.department.short_cut }}</span></p>
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
                                <a href="#department" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                    Department
                                </a>
                            </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                           
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info
                                </h5>
                                <div class="row">
                                  
                                    <CustomInput v-model="currentDepartmentHead.first_name" :errorText="getErrorText(errors, 'first_name')"
                                        :showError="errors.hasOwnProperty('first_name')" label="Enter First Name" 
                                        placeholder="Your First Name" />
                                    <CustomInput v-model="currentDepartmentHead.last_name" :errorText="getErrorText(errors, 'last_name')"
                                        :showError="errors.hasOwnProperty('last_name')" label="Enter last Name" 
                                        placeholder="Your Last name" />
                                    <CustomInput v-model="currentDepartmentHead.email" :errorText="getErrorText(errors, 'email')"
                                        :showError="errors.hasOwnProperty('email')" label="Enter email" 
                                        placeholder="Your email" />
                                  
                                </div> <!-- end row -->
                               


                                <div class="text-end">
                                    <button @click="saveDepartmentHead" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i>Update</button>
                                </div>
                            
                        </div>
                        
                            <div class="tab-pane" id="department">
                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i>
                                    department Info</h5>
                                <div class="row">
                                <CustomInput v-model="currentDepartmentHead.department.name" :errorText="getErrorText(errors, 'name')"
                                    :showError="errors.hasOwnProperty('name')" label="Enter name"
                                    placeholder="Your name" />
                                <CustomInput v-model="currentDepartmentHead.department.short_cut" :errorText="getErrorText(errors, 'short_cut')"
                                    :showError="errors.hasOwnProperty('short_cut')" label="Enter short_cut"
                                    placeholder="Your short_cut" />

                                </div>
                                <div class="text-end">
                                    <button @click="saveDepartment" class="btn btn-success mt-2"><i
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









