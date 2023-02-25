<script setup>
import { defineProps } from 'vue';

const { modelValue, errorText, showError,lable,placeholder,showForgetPassword,forgetPasswordPage } = defineProps(['modelValue', 'errorText', 'showError','lable','placeholder','showForgetPassword','forgetPasswordPage'])


</script>
<template>
  <div  class="mb-3">
    <router-link v-if="showForgetPassword" aria-current="page" :to="{name:forgetPasswordPage}"
        class="router-link-active router-link-exact-active text-muted float-end">
        <small>Forgot
            your password?
        </small>
    </router-link>
    <label v-bind:for="lable" class="form-label">{{lable}}</label>
    <div class="input-group input-group-merge">
        <input 
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        :class="{'is-invalid': showError }"
        class="form-control" type="password" :id="lable"
            :placeholder="placeholder">
        <div role="button" class="input-group-text" data-password="false">
            <span class="password-eye">
            </span>
        </div>
        <div v-if="showError" class="invalid-feedback">
          {{ errorText}}
      </div>
    </div>

</div>
</template>