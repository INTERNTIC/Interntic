<script setup>
import { onMounted } from 'vue';
import { useAuthStore } from '@/stores/AuthStore';
import { useStudentStore, } from '@/stores/StudentStore';

const authStore = useAuthStore();


</script>
<template>
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="page-title">Dashboard</h4>
      </div>
    </div>
  </div>
  <!-- end page title -->

  <div class="row" v-if="authStore.is_student">
    <div class="col-lg-6  m-auto text-center">

      <h2>Welcome to your dashboard</h2>
      <p>Discover and manage internships effortlessly! Our website streamlines the process of requesting internships and
        helps you navigate your internship experience as a student. Join us today to unlock exciting opportunities and
        gain valuable real-world experience.</p>

    </div>
    <div class="col-lg-6 ">
      <img class="img-fluid" src="/assets/images/dash/student.png" alt="">
    </div> <!-- end col-->


  </div>
  <div class="row" v-if="authStore.is_internship_responsible">
    <div class="col-lg-6  m-auto text-center">

      <h2>Welcome to your dashboard</h2>
      <p>
        Simplify internship management with our website! As an internship manager, our platform empowers you to
        efficiently oversee and coordinate internship programs. Seamlessly handle applications, streamline communication
        with interns, and track their progress all in one place. Join us now to optimize your internship management
        process and ensure a successful experience for both interns and your organization.</p>
    </div>
    <div class="col-lg-6 ">
      <img class="img-fluid" src="/assets/images/dash/internship_responsible.png" alt="">
    </div>
  </div>

  <div class="row" v-if="authStore.is_department_head">
    <div class="col-lg-6  m-auto text-center">

      <h2>Welcome to your dashboard</h2>
      <p>
        Effortlessly manage internships as a department head with our website! Streamline the process of overseeing
        internships within your department. Our platform provides you with powerful tools to handle applications,
        coordinate with interns, and track their progress. Join us now to efficiently manage internships and cultivate a
        thriving learning environment within your department..</p>
    </div>
    <div class="col-lg-6 ">
      <img class="img-fluid" src="/assets/images/dash/department.png" alt="">
    </div>
  </div>
  <div class="row" v-if="authStore.is_super_admin">
    <div class="col-lg-6  m-auto text-center">

      <h2>Welcome to your dashboard</h2>
      <p>Welcome to the Super Admin Dashboard! It's a centralized hub that gives administrators complete control and oversight. You can manage users, monitor system performance, and make data-driven decisions. Stay informed, resolve issues quickly, and optimize efficiency with our user-friendly interface</p>
    </div>
    <div class="col-lg-6 ">
      <img class="img-fluid" src="/assets/images/dash/super_admin.png" alt="">
    </div>
  </div>
</template>