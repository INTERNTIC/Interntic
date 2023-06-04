<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import CustomInput from '../components/form/CustomInput.vue';
import CustomPasswordInput from '../components/form/CustomPasswordInput.vue';
import Checkbox from '../components/form/Checkbox.vue';
import { useRoute } from 'vue-router';
import DangerNofitication from '../components/notification/DangerNofitication.vue';
// import { useAuthStore } from '../stores/AuthStore';
import useAuth from "@/composables/Auth.js";
import { getErrorText,Notify } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

const {
    login
} = useAuth()
const route = useRoute();
// const authStore = useAuthStore();



const rememberMe = ref(false)
const loginFormModel = ref({
    'email': '',
    'password': '',
})

const body = document.querySelector('body');
onMounted(() => {
    if (route.query.message) {
        generalSuccessMsg.value = route.query.message;
        Notify(generalSuccessMsg.value, generalErrorMsg.value)   
    }
    body.classList.add('authentication-bg')
})
onUnmounted(() => {
    body.classList.remove('authentication-bg')
})
</script>
<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <router-link :to="{ name: 'statistiques' }">
                                <span>
                                    <h2 style="color: #fff">INTERNTIC</h2>
                                </span>
                            </router-link>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                                <p class="text-muted mb-4">Enter your email address and password to access Dashboard.</p>
                            </div>

                            <form @submit.prevent="login(route.params.guard, rememberMe, loginFormModel)">
                                <CustomInput v-model="loginFormModel.email" label="Email Address"
                                    :errorText="getErrorText(errors, 'email')" :showError="errors.hasOwnProperty('email')"
                                    placeholder="Enter Email Address" inputType="email" />

                                <router-link to="#" class="text-muted float-end"><small>Forgot your
                                        password?</small></router-link>
                                <CustomPasswordInput v-model="loginFormModel.password" label="Password"
                                    :errorText="getErrorText(errors, 'password')"
                                    :showError="errors.hasOwnProperty('password')" placeholder="Enter your password" />



                                <Checkbox label="Remember me" v-model="rememberMe" />
                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3" v-if="route.params.guard!='department_head' && route.params.guard!='super_admin'">
                        <div class="col-12 text-center">
                            <p class="text-muted">Don't have an account? <router-link :to="`/sign-up/${route.params.guard}`"
                                class="text-muted ms-1"><b>Sign Up</b></router-link></p>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2018 -2023 © L3 - INTERNTIC
    </footer>


    <DangerNofitication :errorMsg="generalErrorMsg" />
</template>
