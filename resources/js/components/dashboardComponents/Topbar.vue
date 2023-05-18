<script setup>
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '../../stores/AuthStore';
import useCompanyCause from "@/composables/CompanyCause.js";
import useDepartmentCause from "@/composables/DepartmentCause.js";
import CustomTextAria from '@/components/form/CustomTextAria.vue';
import StandardModal from '@/components/modal/StandardModal.vue';
import { Notify, getErrorText, refreshTable } from "@/newShared";
import {
  generalErrorMsg,
  generalSuccessMsg,
  errors
} from "@/axiosClient";
onMounted(() => {
  get_department_causes();
  $("#full-width-modal").modal("show")
})
const { get_company_causes,
  store_company_cause,
  update_company_cause,
  destroy_company_cause,
  company_causes, } = useCompanyCause();
const { get_department_causes,
  store_department_cause,
  update_department_cause,
  destroy_department_cause,
  department_causes, } = useDepartmentCause();
const authStore = useAuthStore()

const fullName = computed(() => {
  return `${authStore.authUser.first_name} ${authStore.authUser.last_name}`
})
const guard = computed(() => {
  return `${authStore.userGuard}`
})

const cause_exemple = {
  id: "",
  cause: ""
}

const current_cause = ref(Object.create(cause_exemple))
const save_cause = async () => {
  await store_department_cause(current_cause.value)
  Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
      await get_department_causes();
      current_cause.value = Object.create(cause_exemple);
      $("#add-cause-modal").modal("hide");
      $("#full-width-modal").modal("show")
    }
}
const delete_cause = async (department_cause_id) => {
  await destroy_department_cause(department_cause_id)
  Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == '') {
      await get_department_causes();
    }
}
const show_manage_modal = async () => {
  get_department_causes();
  $("#full-width-modal").modal("show")
}
const show_add_modal = async () => {
  $("#add-cause-modal").modal("show")
}
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
            <img src="/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
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

          <div v-if="authStore.is_department_head" role="button" class="dropdown-item notify-item"
            @click="show_manage_modal()">
            <i class="mdi mdi-account-circle me-1"></i>
            <span>Manage Causes</span>
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
  <FullWidthModal>
    <template v-slot:body>
      <div class="row">
        <template v-for="department_cause,index in department_causes" :key="department_cause.id" >
          
          <div class="col-md-6">
            <CustomTextAria :modelValue="department_cause.cause" :errorText="getErrorText(errors, 'note')"
            :showError="errors.hasOwnProperty('note')" label="Enter a Note" placeholder="Enter a Note" />
            <button type="button" class="btn btn-light me-2 mb-1 ">Edit</button>
            <button type="button" @click="delete_cause(department_cause.id)" class="btn btn-light mb-2 mt-1">Delete</button>
          </div>
          <hr v-if="index%2==1">
        </template>
        
      </div>
    </template>
    <template v-slot:buttons>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      <button type="button" @click="show_add_modal" class="btn btn-light" data-bs-dismiss="modal">Add new Cause</button>
    </template>
  </FullWidthModal>

  <StandardModal id="add-cause-modal" modal-header="Add New Cause">
    <template v-slot:body>
      <div class="row">
        <div class="col-md-6">
          <CustomTextAria v-model="current_cause.cause" :errorText="getErrorText(errors, 'cause')"
            :showError="errors.hasOwnProperty('cause')" label="Enter a Cause" placeholder="Enter a Cause" />
        </div>
      </div>
    </template>
    <template v-slot:buttons>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      <button type="button" @click="save_cause" class="btn btn-light">Save</button>
    </template>
  </StandardModal>
</template>