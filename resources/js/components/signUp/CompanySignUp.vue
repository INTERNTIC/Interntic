<script setup>
import { ref } from 'vue';
import CustomInput from '../form/CustomInput.vue';
import useAuth from '../../composables/Auth';
import shared from '../../shared.js'
const formModel = ref({
    first_name:'',
    last_name:'',
    email:'',
    phone:'',
    password:'',
    confirm_password:'',
    company_location:'',
    company_name:'',
});
const { companySignUp, errors } = useAuth();
</script>
<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <router-link :to="{ name: 'dashboard' }">
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
                                    <h4 class="header-title">Date Range Picker</h4>
                                    <p class="text-muted font-14">
                                        A JavaScript component for choosing date ranges, dates and times.
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="daterange-picker-preview">
                                            <form @submit.prevent="companySignUp(formModel)">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.first_name" label="First Name" :errorText="shared.getErrorText(errors,'first_name')"
                                                        :showError="errors.hasOwnProperty('first_name')" placeholder="Enter First Name" inputType="text" />
                                                    </div>
                                                
                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.last_name" label="Last Name" :errorText="shared.getErrorText(errors,'last_name')"
                                                        :showError="errors.hasOwnProperty('last_name')" placeholder="Enter Last Name" inputType="text" />
                                                   
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.email" label="Email Address" :errorText="shared.getErrorText(errors,'email')"
                                                        :showError="errors.hasOwnProperty('email')" placeholder="Enter Email Address" inputType="email" />
                                                   
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.phone" label="Phone" :errorText="shared.getErrorText(errors,'phone')"
                                                        :showError="errors.hasOwnProperty('phone')" placeholder="Enter Phone Number" inputType="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.password" label="Pasword" :errorText="shared.getErrorText(errors,'password')"
                                                        :showError="errors.hasOwnProperty('password')" placeholder="Enter Pasword" inputType="password" />
                                                   
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.confirm_password" label="Confirm Password" :errorText="shared.getErrorText(errors,'confirm_password')"
                                                        :showError="errors.hasOwnProperty('confirm_password')" placeholder="Enter Confirm Password" inputType="password" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <CustomInput v-model="formModel.company_name" label="Company Name" :errorText="shared.getErrorText(errors,'company_name')"
                                                        :showError="errors.hasOwnProperty('company_name')" placeholder="Enter Company Name" inputType="text" />
                                                   
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <CustomInput v-model="formModel.company_location" label="Company Location" :errorText="shared.getErrorText(errors,'company_location')"
                                                        :showError="errors.hasOwnProperty('company_location')" placeholder="Enter Company Location" inputType="text" />
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
    </div>
</template>