<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { Notify, getErrorText } from "@/newShared";
import useAuth from "@/composables/Auth.js"
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

import FloatingInput from '../components/form/FloatingInput.vue';
const { resetPassword } = useAuth();
const route = useRoute();
const token = route.query.token
const guard = route.query.guard
const passwordObject = {
    token: token,
    guard: guard,
    email: "",
    password: "",
    password_confirmation: "",
}
const password_reset = ref(_.cloneDeep(passwordObject))
const submitPassword = async () => {
    console.log(password_reset.value);
    await resetPassword(password_reset.value)
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
        password_reset.value = _.cloneDeep(passwordObject)
    }

}
</script>
<template>
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
                            <FloatingInput v-model="password_reset.email" :errorText="getErrorText(errors, 'email')"
                                :showError="errors.hasOwnProperty('email')" label="email" placeholder="Enter email" />
                        </div>
                        <div class="col-lg-6">
                            <FloatingInput v-model="password_reset.password" :errorText="getErrorText(errors, 'password')"
                                :showError="errors.hasOwnProperty('password')" label="Password"
                                placeholder="Enter Password" />
                        </div>
                        <div class="col-lg-6">
                            <FloatingInput v-model="password_reset.password_confirmation"
                                :errorText="getErrorText(errors, 'password_confirmation')"
                                :showError="errors.hasOwnProperty('password_confirmation')" label="Confirm Password"
                                placeholder="Enter Password again" />
                        </div>
                        <div>
                            <button @click="submitPassword" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
</template>





