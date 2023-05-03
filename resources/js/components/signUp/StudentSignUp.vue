<script setup>
import { ref } from 'vue';
import CustomInput from '../form/CustomInput.vue';
import PasswordInput from '../form/PasswordInput.vue';
import useAuth from '../../composables/Auth';
import {Notify,getErrorText,refreshTable} from "@/newShared";

const formModel = ref({
    email: '',
    password: '',
    confirm_password: '',
    student_card: '',
});
const { studentSignUp, errors } = useAuth();
</script>
<template>
    <div class="container-lg scroll m-0 mt-2 d-flex">
        <div class="row">
            <div class="col-xxl-8 col-lg">
                <div class="card d-block">

                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="/" class="">
                            <span>

                                <h2 style="color: rgb(255, 255, 255);">INTERNTIC
                                </h2>
                            </span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                            <p class="text-muted mb-4">Enter your email address and password to access Dashboard.</p>
                        </div>

                        <form @submit.prevent="studentSignUp(formModel)">
                            <CustomInput v-model="formModel.student_card" label="Student Card"
                                :errorText="getErrorText(errors, 'student_card')"
                                :showError="errors.hasOwnProperty('student_card')" placeholder="Enter Student Card Number"
                                inputType="text" />

                            <CustomInput v-model="formModel.email" label="Email Address"
                                :errorText="getErrorText(errors, 'email')" :showError="errors.hasOwnProperty('email')"
                                placeholder="Enter Email Address" inputType="email" />                       

                            <PasswordInput
                            v-model="formModel.confirm_password"
                            :errorText="getErrorText(errors, 'confirm_password')"
                            lable="Password"
                            placeholder="Enter a Strong Password"
                            :showError="errors.hasOwnProperty('confirm_password')"
                            :showForgetPassword="false"
                            forgetPasswordPage=""
                            />
                            <PasswordInput
                            v-model="formModel.password"
                            :errorText="getErrorText(errors, 'password')"
                            lable="Confirm Password"
                            placeholder="Enter Passord Again"
                            :showError="errors.hasOwnProperty('password')"
                            :showForgetPassword="false"
                            forgetPasswordPage=""
                            />
                         
                            <div class="mb-3 text-center">
                                <button class="btn btn-primary mb-3" type="submit"> Sign Up</button>
                        </div>

                        </form>
                        <footer class="footer footer-alt">
                            <p class="text-muted">Already have account? <a href="pages-login-2.html" class="text-muted ms-1"><b>Log In</b></a></p>
                        </footer>

                    </div>

                </div>


            </div>

            <!-- 
                    <div class="col-xxl-8 col-lg-6">

                </div> -->

        </div>

    </div>
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