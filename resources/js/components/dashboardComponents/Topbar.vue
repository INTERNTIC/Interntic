<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useAuthStore } from '../../stores/AuthStore';
import useCompanyCause from "@/composables/CompanyCause.js";
import useDepartmentCause from "@/composables/DepartmentCause.js";
import CustomTextAria from '@/components/form/CustomTextAria.vue';
import StandardModal from '@/components/modal/StandardModal.vue';
import { Notify, getErrorText } from "@/newShared";
import {
  generalErrorMsg,
  generalSuccessMsg,
  errors
} from "@/axiosClient";


const authStore = useAuthStore();



const fullName = computed(() => {
  if(!authStore.authUser.first_name && !authStore.authUser.last_name){
    if (authStore.userGuard=="super_admin") {
      return "Super Admin";
    }
  }
  return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})

const guard = computed(() => {
  return `${authStore.userGuard}`
})



</script>
<template>
  <div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">
      <li class="notification-list">
        <a class="nav-link end-bar-toggle" href="javascript: void(0);">
          <i class="dripicons-gear noti-icon"></i>
        </a>
      </li>

      <li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button"
          aria-haspopup="false" aria-expanded="false">
          <span class="account-user-avatar">
            
            <img v-if="authStore.is_department_head" src="/assets/images/users/department_head.png" alt="user-image" class="rounded-circle">
            <img v-if="authStore.is_internship_responsible" src="/assets/images/users/internship_responsible.png" alt="user-image" class="rounded-circle">
            <img v-if="authStore.is_student" src="/assets/images/users/student.png" alt="user-image" class="rounded-circle">
            <img v-if="authStore.is_super_admin" src="/assets/images/users/super_admin.png" alt="user-image" class="rounded-circle">

          </span>
          <span>
            <span class="account-user-name">{{ fullName }}</span>
            <span class="account-position">{{ guard }}</span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
          <!-- item-->
          <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome !</h6>
          </div>


          <router-link :to="{ name: 'profile' }" class="dropdown-item notify-item">
            <i class="mdi mdi-account-circle me-1"></i>
            <span>My Account</span>
          </router-link>


          <router-link :to="{ name: 'updatePassword' }" class="dropdown-item notify-item">
            <i class="mdi mdi-lock-outline me-1"></i>
            <span>Change Password</span>
          </router-link>
          <router-link :to="{ name: 'logout' }" class="dropdown-item notify-item">
            <i class="mdi mdi-logout me-1"></i>
            <span>Logout</span>
          </router-link>
        </div>
      </li>

    </ul>
    <button class="button-menu-mobile open-left">
      <i class="mdi mdi-menu"></i>
    </button>

  </div>
</template>
<style scoped>
button[disabled] {
  color: gray;
  opacity: 0.5;
  cursor: not-allowed;
}
</style>