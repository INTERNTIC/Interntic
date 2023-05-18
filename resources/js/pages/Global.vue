<script setup>
import { onMounted } from 'vue';

const body = document.querySelector('body');
onMounted(() => {
  body.classList.remove('loading')
})

</script>
<template>
  <notifications  :pauseOnHover="true"  :closeOnClick="true" />
  <router-view></router-view>
</template>
<style>
.vue-notification-group{
  top:1rem !important;
  cursor: pointer;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
a{
  white-space: pre-line !important;
}
</style>