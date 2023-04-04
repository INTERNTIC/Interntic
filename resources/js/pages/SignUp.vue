<script setup>
import { onMounted } from 'vue';
// import { useAuthStore } from '@/stores/AuthStore';
// const AuthStore = useAuthStore();
onMounted(() => {
    const body=document.querySelector('body');
    body.classList.add('authentication-bg')
})
</script>

<template >
    <router-view></router-view>
    <footer class="footer footer-alt">
        2023 ©  INTERNTIC 
    </footer>
</template>
