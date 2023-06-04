<script setup>
import { ref } from 'vue';
import { onMounted } from 'vue';
import CustomPasswordInput from '@/components/form/CustomPasswordInput.vue';
import { Notify, getErrorText } from "@/newShared";
import { useLoading } from 'vue-loading-overlay';
import useAuth from "@/composables/Auth.js";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const { student_sing_up } = useAuth();
const $loading = useLoading({});
onMounted(() => {
    const body = document.querySelector('body');
    body.classList.add('authentication-bg')
})

const formModelExemple = {
    email: '',
    password: '',
    password_confirmation: '',
    student_card: '',
}
const formModel = ref(Object.create(formModelExemple));
const studentSignUp = async () => {
    const loader = $loading.show({
        color: 'green',
    });
    await student_sing_up(formModel.value);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalSuccessMsg.value != '') {
        formModel.value = Object.create(formModelExemple);
    }
    loader.hide()
}
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
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign Up</h4>
                                <p class="text-muted mb-4">Enter your Info to sign up.</p>
                            </div>

                            <form @submit.prevent="studentSignUp(formModel)">
                                <CustomInput v-model="formModel.student_card" label="Student Card"
                                    :errorText="getErrorText(errors, 'student_card')"
                                    :showError="errors.hasOwnProperty('student_card')"
                                    placeholder="Enter Student Card Number" inputType="text" />

                                <CustomInput v-model="formModel.email" label="Email Address"
                                    :errorText="getErrorText(errors, 'email')" :showError="errors.hasOwnProperty('email')"
                                    placeholder="Enter Email Address" inputType="email" />

                                <CustomPasswordInput v-model="formModel.password"
                                    :errorText="getErrorText(errors, 'password')" placeholder="Enter Passord Again"
                                    label="Password" :showError="errors.hasOwnProperty('password')"
                                    :showForgetPassword="false" />
                                <CustomPasswordInput v-model="formModel.password_confirmation"
                                    :errorText="getErrorText(errors, 'password_confirmation')"
                                    placeholder="Enter a Strong Password" label="Confirm Password"
                                    :showError="errors.hasOwnProperty('password_confirmation')"
                                    :showForgetPassword="false" />

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary mb-3" type="submit"> Sign Up</button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">alredy have an account? <router-link :to="{ name: 'login', params: { guard: 'student' } }"
                                    class="text-muted ms-1"><b>Login</b></router-link></p>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2018 -2023 © Hyper - Coderthemes.com
    </footer>
</template>


<style scoped>
body {
    background: url('./assets/images/bg-auth.jpg') center !important;
    background-size: cover !important;
    background-repeat: no-repeat;
}

body::after {
    content: "";
    background: rgba(232, 232, 232, 0.315);
    opacity: 0.5;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: absolute;
    z-index: -1;
}

html {
    overflow: hidden !important;
}

.scroll {
    max-height: 100vh !important;
    overflow: auto;
    -ms-overflow-style: none;
    /* Internet Explorer 10+ */
    scrollbar-width: none;
    /* Firefox */
}


.scroll::-webkit-scrollbar {
    display: none;
    /* Safari and Chrome */
}
</style>
<script setup>

</script>

