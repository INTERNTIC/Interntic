<script setup>
import { onMounted, watch } from 'vue';
import { useAuthStore, } from '@/stores/AuthStore';
import { useStudentStore, } from '@/stores/StudentStore';
import { useRoute } from 'vue-router';
const authStore = useAuthStore()
const studentStore = authStore.is_student ? useStudentStore() : null;



const route = useRoute();
onMounted(() => {
  if (authStore.is_student) {
      studentStore.count_accepted_internships();
      studentStore.count_refused_internships();
      studentStore.count_passed_internships();
      studentStore.count_requested_internships();
    }
  // import('@/assets/app.min.js').then(() => {
  window.jQuery.App.init()
  // })
})
watch(
  () => route.fullPath,
  () => {
    if (authStore.is_student) {
      studentStore.count_accepted_internships();
      studentStore.count_refused_internships();
      studentStore.count_passed_internships();
      studentStore.count_requested_internships();
    }
  }
);
</script>
<template>
  <router-view></router-view>
</template>