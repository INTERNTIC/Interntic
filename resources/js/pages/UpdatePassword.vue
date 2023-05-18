<script setup>
import { ref } from 'vue';
import { Notify, getErrorText } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
import FloatingInput from '../components/form/FloatingInput.vue';
import CustomPasswordInput from '../components/form/CustomPasswordInput.vue';
import useAuth from "@/composables/auth.js";
const { updatePassword } = useAuth()

const passwordObject = {
    old_password: "",
    password: "",
    password_confirmation: "",
}
const password_update = ref(_.cloneDeep(passwordObject))

const submitPassword = async () => {
    await updatePassword(password_update.value)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        password_update.value = _.cloneDeep(passwordObject)
    }
}
</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Manage Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Update Password</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Password Reset</h4>
                    <p class="text-muted font-14">
                        Enter a strong and secure password
                    </p>
                    <div class="row">
                       
                        <div class="col-lg-6">

                            <CustomPasswordInput v-model="password_update.old_password"
                                :errorText="getErrorText(errors, 'old_password')"
                                :showError="errors.hasOwnProperty('old_password')" label="Old Password"
                                placeholder="Enter Old Password" />
                        </div>
                        <div class="col-lg-6">
                            <CustomPasswordInput v-model="password_update.password" :errorText="getErrorText(errors, 'password')"
                                :showError="errors.hasOwnProperty('password')" label="Password"
                                placeholder="Enter Password" />
                        </div>
                        <div class="col-lg-6">
                            <CustomPasswordInput v-model="password_update.password_confirmation"
                                :errorText="getErrorText(errors, 'password_confirmation')"
                                :showError="errors.hasOwnProperty('password_confirmation')" label="Confirm Password"
                                placeholder="Enter Password again" />
                        </div>
                        <div>
                            <button @click="submitPassword" class="btn btn-primary">Submit</button>
                        </div>

                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
</template>





