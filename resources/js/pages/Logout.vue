<script setup>
import useAuth from '@/composables/Auth.js';
import { onBeforeMount } from 'vue';
import { useRouter } from 'vue-router';
const router=useRouter();
const { logout } = useAuth();
onBeforeMount(async () => {
    await logout();
    router.push({name:"login",params:{"guard":"/"}})
})
</script>
<template>
</template>