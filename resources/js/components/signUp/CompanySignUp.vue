<script setup>
import { ref } from 'vue';
import CustomPasswordInput from '@/components/form/CustomPasswordInput.vue';
import { useLoading } from 'vue-loading-overlay';
import useAuth from "@/composables/Auth.js";
import {Notify,getErrorText,refreshTable} from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const {internship_responsible_sign_up } = useAuth();
const $loading = useLoading({});

const formModelExemple ={    
    first_name:'',
    last_name:'',
    email:'',
    phone:'',
    password:'',
    password_confirmation:'',
    company_location:'',
    company_name:'',
}
const formModel = ref(Object.create(formModelExemple));
const internshipResponsiblSignUp = async () => {
    const loader = $loading.show({
        color: 'green',
    });
    await internship_responsible_sign_up(formModel.value);
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
                <div class="card">
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <router-link :to="{ name: 'statistiques' }">
                            <span>
                                <h2 style="color: #fff">INTERNTIC</h2>
                            </span>
                        </router-link>
                    </div>
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-2 fw-bold">Free Sign Up</h4>
                        <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a
                            minute </p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">internship responsible Sign up</h4>
                                    <p class="text-muted font-14">
                                        Enter your info to sign up
                                    </p>
                                   
                                    <form @submit.prevent="internshipResponsiblSignUp">
                                        <CustomInput v-model="formModel.first_name"
                                            :errorText="getErrorText(errors, 'first_name')"
                                            :showError="errors.hasOwnProperty('first_name')"
                                            label="First name"
                                            placeholder="Enter Your First name" />
                                        <CustomInput v-model="formModel.last_name"
                                            :errorText="getErrorText(errors, 'last_name')"
                                            :showError="errors.hasOwnProperty('last_name')"
                                            label="Last name"
                                            placeholder="Enter Your Last name" />
        
                                        <CustomInput v-model="formModel.email"
                                            :errorText="getErrorText(errors, 'email')"
                                            :showError="errors.hasOwnProperty('email')"
                                            label="Email"
                                            inputType="email"
                                            placeholder="Enter Your Email" />
                                        <CustomInput v-model="formModel.phone"
                                            :errorText="getErrorText(errors, 'phone')"
                                            :showError="errors.hasOwnProperty('phone')"
                                            label="Phone"
                                            placeholder="Enter Your company_name"
                                            inputType="number" />
                                        <CustomInput v-model="formModel.company_name"
                                            :errorText="getErrorText(errors, 'company_name')"
                                            :showError="errors.hasOwnProperty('company_name')"
                                            label="company_name"
                                            placeholder="Enter Your company_name" />
                                        <CustomInput v-model="formModel.company_location"
                                            :errorText="getErrorText(errors, 'company_location')"
                                            :showError="errors.hasOwnProperty('company_location')"
                                            label="company_location"
                                            placeholder="Enter Your company_location" />
        
        
                                        <CustomPasswordInput v-model="formModel.password"
                                            :errorText="getErrorText(errors, 'password')" placeholder="Enter Passord Again"
                                            label="Password" :showError="errors.hasOwnProperty('password')"
                                            />
                                        <CustomPasswordInput v-model="formModel.password_confirmation"
                                            :errorText="getErrorText(errors, 'password_confirmation')"
                                            placeholder="Enter a Strong Password" label="Confirm Password"
                                            :showError="errors.hasOwnProperty('password_confirmation')"
                                            />
        
                                        <div class="mb-3 text-center">
                                            <button class="btn btn-primary mb-3" type="submit"> Sign Up</button>
                                        </div>
        
                                    </form>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row mt-1">
                        <div class="col-12 text-center">
                            <p class="text-muted">alredy have an account? <router-link :to="{ name: 'login', params: { guard: 'internship_responsible' } }"
                                    class="text-muted ms-1"><b>Login</b></router-link></p>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
</template>