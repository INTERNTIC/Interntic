<script setup>
import { ref } from 'vue';
import CustomPasswordInput from '@/components/form/CustomPasswordInput.vue';
import { useLoading } from 'vue-loading-overlay';
import useAuth from "@/composables/Auth.js";
import { Notify, getErrorText, refreshTable } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";
const { department_sign_up } = useAuth();
const $loading = useLoading({});

const formModelExemple = {
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    company_location: '',
    company_name: '',
}
const formModel = ref(Object.create(formModelExemple));
const internshipResponsiblSignUp = async () => {
    const loader = $loading.show({
        color: 'green',
    });
    await department_sign_up(formModel.value);
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
                        <h4 class="text-dark-50 text-center mt-2 fw-bold">Create Department Head Account</h4>
                        <p class="text-muted mb-4"> Creating an account, it takes less than a
                            minute </p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Insert Department Head Info</h4>
                                    <p class="text-muted font-14">
                                        A JavaScript component for choosing date ranges, dates and times.
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="daterange-picker-preview">
                                            <form @submit.prevent="departmentSignUp(formModel)">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.first_name" label="First Name"
                                                            :errorText="getErrorText(errors, 'first_name')"
                                                            :showError="errors.hasOwnProperty('first_name')"
                                                            placeholder="Enter First Name" inputType="text" />
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.last_name" label="Last Name"
                                                            :errorText="getErrorText(errors, 'last_name')"
                                                            :showError="errors.hasOwnProperty('last_name')"
                                                            placeholder="Enter Last Name" inputType="text" />

                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.email" label="Email Address"
                                                            :errorText="getErrorText(errors, 'email')"
                                                            :showError="errors.hasOwnProperty('email')"
                                                            placeholder="Enter Email Address" inputType="email" />

                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.phone" label="Phone"
                                                            :errorText="getErrorText(errors, 'phone')"
                                                            :showError="errors.hasOwnProperty('phone')"
                                                            placeholder="Enter Phone Number" inputType="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.password" label="Pasword"
                                                            :errorText="getErrorText(errors, 'password')"
                                                            :showError="errors.hasOwnProperty('password')"
                                                            placeholder="Enter Pasword" inputType="password" />

                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.confirm_password"
                                                            label="Confirm Password"
                                                            :errorText="getErrorText(errors, 'confirm_password')"
                                                            :showError="errors.hasOwnProperty('confirm_password')"
                                                            placeholder="Enter Confirm Password" inputType="password" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.department_name"
                                                            label="Department Name"
                                                            :errorText="getErrorText(errors, '.department_name')"
                                                            :showError="errors.hasOwnProperty('.department_name')"
                                                            placeholder="Enter Department Name" inputType="text" />

                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.department_short_cut"
                                                            label="Department Short Cut"
                                                            :errorText="getErrorText(errors, 'department_short_cut')"
                                                            :showError="errors.hasOwnProperty('department_short_cut')"
                                                            placeholder="Enter Department Short Cut" inputType="text" />
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Submit form</button>
                                            </form>
                                        </div> <!-- end preview-->

                                        <div class="tab-pane" id="daterange-picker-code">
                                            <pre
                                            class="mb-0"><span class="html escape hljs xml"><span class="hljs-comment">&lt;!-- Date Range --&gt;</span><br><span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-3"</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Date Range<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control date"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"singledaterange"</span> <span class="hljs-attr">data-toggle</span>=<span class="hljs-string">"date-picker"</span> <span class="hljs-attr">data-cancel-class</span>=<span class="hljs-string">"btn-warning"</span>&gt;</span><br><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><br><br><span class="hljs-comment">&lt;!-- Date Range Picker With Times --&gt;</span><br><span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-3"</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Date Range Picker With Times<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control date"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"daterangetime"</span> <span class="hljs-attr">data-toggle</span>=<span class="hljs-string">"date-picker"</span> <span class="hljs-attr">data-time-picker</span>=<span class="hljs-string">"true"</span> <span class="hljs-attr">data-locale</span>=<span class="hljs-string">"{'format': 'DD/MM hh:mm A'}"</span>&gt;</span><br><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><br><br><span class="hljs-comment">&lt;!-- Single Date Picker --&gt;</span><br><span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-3"</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Single Date Picker<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control date"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"birthdatepicker"</span> <span class="hljs-attr">data-toggle</span>=<span class="hljs-string">"date-picker"</span> <span class="hljs-attr">data-single-date-picker</span>=<span class="hljs-string">"true"</span>&gt;</span><br><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><br><br><span class="hljs-comment">&lt;!-- Predefined Date Ranges --&gt;</span><br><span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-3"</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-label"</span>&gt;</span>Predefined Date Ranges<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span><br>    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"reportrange"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form-control"</span> <span class="hljs-attr">data-toggle</span>=<span class="hljs-string">"date-picker-range"</span> <span class="hljs-attr">data-target-display</span>=<span class="hljs-string">"#selectedValue"</span>  <span class="hljs-attr">data-cancel-class</span>=<span class="hljs-string">"btn-light"</span>&gt;</span><br>        <span class="hljs-tag">&lt;<span class="hljs-name">i</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mdi mdi-calendar"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">i</span>&gt;</span>&amp;nbsp;<br>        <span class="hljs-tag">&lt;<span class="hljs-name">span</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"selectedValue"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span> <span class="hljs-tag">&lt;<span class="hljs-name">i</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mdi mdi-menu-down"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">i</span>&gt;</span><br>    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><br><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span></span></pre>
                                        <!-- end highlight-->
                                    </div> <!-- end preview code-->
                                </div> <!-- end tab-content-->

                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>

            </div>

        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div></template>