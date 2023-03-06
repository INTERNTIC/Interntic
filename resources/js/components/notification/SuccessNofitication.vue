<script setup>
import { defineProps } from 'vue';
const {successMsg}=defineProps(['successMsg'])
</script>

<template>
    <div v-if="successMsg!=''" class="jq-toast-wrap top-right">
        <div class="jq-toast-single jq-has-icon jq-icon-success" style="text-align: left;"><span
                class="jq-toast-loader jq-toast-loaded"
                style="-webkit-transition: width 2.6s ease-in;-o-transition: width 2.6s ease-in;transition: width 2.6s ease-in;background-color: rgba(0,0,0,0.2);">
            </span>
            <span class="close-jq-toast-single">×</span>
            <h2 class="jq-toast-heading">Oh Opps!</h2>{{ successMsg}}
        </div>
    </div>
</template>