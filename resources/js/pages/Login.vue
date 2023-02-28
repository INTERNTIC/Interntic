
<script setup>
import { ref, onBeforeMount,onMounted } from 'vue';
import useAuth from '../composables/Auth.js'
import CustomInput from '../components/form/CustomInput.vue';
import Checkbox from '../components/form/Checkbox.vue';
import { useRoute } from 'vue-router';
import DangerNofitication from '../components/notification/DangerNofitication.vue';
import { useRouter } from 'vue-router';
const { login, errors, generalErrorMsg } = useAuth();
const router = new useRouter();
const route = useRoute()
 


const rememberMe = ref(false)
const loginFormModel = ref({
    'email': '',
    'password': '',
})


const getErrorText = (ErrorObject, property) => {
    return ErrorObject.hasOwnProperty(property) ? ErrorObject[property][0] : "";
}
onBeforeMount(() => {
    // redirect user to dashboard if he is authenticated
    // if (shared.isUserCredentialsSaved()) {
    //     router.push({ name: 'dashboard' })
    // }
})
onMounted(() => {
    const body = document.querySelector('body');
    body.classList.add('authentication-bg')
})

</script>
<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <router-link :to="{ name: 'dashboard' }">
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
                                {{ loginFormModel }}
                                <CustomInput v-model="loginFormModel.email" label="Email Address"
                                    :errorText="getErrorText(errors, 'email')" :showError="errors.hasOwnProperty('email')"
                                    placeholder="Enter Email Address" inputType="email" />
                                <div class="mb-3">
                                    <router-link to="#" class="text-muted float-end"><small>Forgot your
                                            password?</small></router-link>
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input :class="{ 'is-invalid': errors.hasOwnProperty('password') }"
                                            v-model="loginFormModel.password" type="password" id="password"
                                            class="form-control" placeholder="Enter your password">
                                        <div role="button" class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        <div v-if="errors.hasOwnProperty('password')" class="invalid-feedback">
                                            {{ getErrorText(errors, 'password') }}
                                        </div>
                                    </div>
                                </div>


                                <Checkbox label="Remember me" v-model="rememberMe" />
                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Don't have an account? <router-link :to="{ name: 'signUp' }"
                                    class="text-muted ms-1"><b>Sign Up</b></router-link></p>
                        </div> <!-- end col -->
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
        2018 -2023 © Hyper - Coderthemes.com
    </footer>


    <DangerNofitication :errorMsg="generalErrorMsg" />
</template>
