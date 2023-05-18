<script setup>
import { onBeforeMount } from 'vue';

import useAuth from "@/composables/Auth.js"
const {
    logout
}=useAuth()

onBeforeMount( async() => {
   await logout();
})

</script>

<template>

</template>