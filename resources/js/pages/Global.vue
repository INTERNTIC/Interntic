<script setup>

</script>
<template>
  <notifications :pauseOnHover="true" :duration="300000" :closeOnClick="true" />
  <router-view></router-view>
</template>
<style>
.vue-notification-group{
  top:1rem !important;
  cursor: pointer;
}
</style>