<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/AuthStore';
import { getErrorText,Notify } from "@/newShared";
import { computed } from 'vue';

import useStudent from '@/composables/Student.js';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {
    updateStudent,
} = useStudent();

const authStore = useAuthStore();

const currentStudent = ref(authStore.authUser);

const full_name = computed(() => {
    return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})
const saveStudent = async () => {
    await updateStudent(currentStudent.value)
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
                    <img src="assets/images/users/student.png" class="rounded-circle avatar-lg img-thumbnail"
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
                        <p class="text-muted mb-2 font-13"><strong>Student Card :</strong> <span class="ms-2 ">{{
                            authStore.authUser.student_card }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Level :</strong> <span class="ms-2 ">{{
                            authStore.authUser.level }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Major :</strong> <span class="ms-2 ">{{
                            authStore.authUser.major }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>social security number :</strong> <span class="ms-2 ">{{
                            authStore.authUser.social_security_num }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>birthday :</strong> <span class="ms-2 ">{{
                            authStore.authUser.birthday }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>place of birth :</strong> <span class="ms-2 ">{{
                            authStore.authUser.place_of_birth }}</span></p>
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
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                           
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info
                                </h5>
                                <div class="row">

                                    <CustomInput v-model="currentStudent.phone" :errorText="getErrorText(errors, 'phone')"
                                        :showError="errors.hasOwnProperty('phone')" label="Enter Phone" input-type="number"
                                        placeholder="Your Phone" />
                                </div> <!-- end row -->

                                <div class="text-end">
                                    <button @click="saveStudent" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i>Update</button>
                                </div>
                            
                        </div>
                        
                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    
</template>
<style></style>









