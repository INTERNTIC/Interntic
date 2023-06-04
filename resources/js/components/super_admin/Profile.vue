<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/AuthStore';
import { getErrorText, Notify } from "@/newShared";
import { computed } from 'vue';

import use_super_admin from '@/composables/SuperAdmin.js';
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {
    get_super_admins,
    store_super_admin,
    update_super_admin,
    destroy_super_admin,
    super_admins,
} = use_super_admin();

const authStore = useAuthStore();

const current_super_admin = ref(authStore.authUser);

const full_name = computed(() => {
    return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})
const save_super_admin = async () => {
    await update_super_admin(current_super_admin.value.id,current_super_admin.value)
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
    

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="assets/images/users/super_admin.png" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">

                   
                    <p class="text-muted font-14">{{ authStore.userGuard }}</p>


                    <div class="text-start mt-3">

              

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{
                            authStore.authUser.email }}</span></p>
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

                                <CustomInput v-model="current_super_admin.email" :errorText="getErrorText(errors, 'email')"
                                    :showError="errors.hasOwnProperty('email')" label="Enter Email" input-type="email"
                                    placeholder="Your Email" />
                            </div>

                            <div class="text-end">
                                <button @click="save_super_admin" class="btn btn-success mt-2"><i
                                        class="mdi mdi-content-save"></i>Update</button>
                            </div>

                        </div>

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
</template>
<style></style>









