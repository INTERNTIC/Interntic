<script setup>
import { useAuthStore, } from '@/stores/AuthStore';
import { computed,onUpdated } from 'vue';
import { useStudentStore, } from '@/stores/StudentStore';
onUpdated(() => {
  console.log('updated');
})
const authStore = useAuthStore()
const studentStore = authStore.is_student ? useStudentStore() : null;

</script>
<template>
  <div class="leftside-menu">

    <!-- LOGO -->
    <router-link :to="{ name: 'statistiques' }" class="logo text-center logo-light">
      <span class="logo-lg">
        <img src="/assets/images/logo.png" alt="" height="16">
      </span>
      <span class="logo-sm">
        <img src="/assets/images/logo_sm.png" alt="" height="16">
      </span>
    </router-link>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
      <span class="logo-lg">
        <img src="/assets/images/logo-dark.png" alt="" height="16">
      </span>
      <span class="logo-sm">
        <img src="/assets/images/logo_sm_dark.png" alt="" height="16">
      </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

      <!--- Sidemenu -->
      <ul class="side-nav">

        <li class="side-nav-title side-nav-item">Pages</li>

        
        <li class="side-nav-item">
          <router-link class="side-nav-link " :to="{ name: 'statistiques' }">
           
            <i class="dripicons-graduation"></i>
            <span> Dashboards </span>
          </router-link>
        </li>

        <li class="side-nav-title side-nav-item">Services</li>

        <template v-if="authStore.is_department_head">
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'manageStudentsAccounts' }">
             
              <i class="dripicons-graduation"></i>
              <span>
                Manage Students Accounts
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'departmentHeadManageInternshipRequests' }">
              
              <i class="uil-package"></i>
              <span>
                Manage Internship Requests
              </span>
            </router-link>
          </li>
         

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'manageInternshipResponsibleAccounts' }">
            
              <i class="dripicons-briefcase"></i>
              <span>
                Manage Internship Responsible Accounts
              </span>
            </router-link>
          </li>
        </template>




        <template v-if="authStore.is_internship_responsible">
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'offers' }">
              <i class="uil-package"></i>
              <span>
                Manage Offers
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'marks' }">
              <i class="dripicons-document-edit"></i>
              <span>
                Manage Marks
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'assessments' }">
              <i class="uil-folder-plus"></i>
              <span>
                Manage Assessments
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'assessStudents' }">

              <i class="dripicons-graduation"></i>
              <span>
                Assess Students
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center"
              :to="{ name: 'internshipResponsibleManageInternshipRequests' }">

              <i class="dripicons-briefcase"></i>
              <span>
                Manage Internship Requests
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center"
              :to="{ name: 'allStudents' }">
              <i class="dripicons-briefcase"></i>
              <span>
                All Students
              </span>
            </router-link>
          </li>

        </template>




        <template v-if="authStore.is_student">

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentInternshipRequests' }">
              <i class="uil-package"></i>
              <span>
                Manage Internship Requests
              </span>
              <span class="badge bg-success float-end">{{studentStore.requested_internships}}</span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentOffers' }">
              <i class="dripicons-to-do"></i>
              <span>
                View Companies's Offers
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentCv' }">
              <i class="uil-folder-plus"></i>
              <span>
                Manage My cv
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'passedInternships' }">

              <i class="uil-package"></i>
              <span>
                Passed / Current Internships
              </span>
              <span class="badge bg-success float-end">{{studentStore.passed_internships}}</span>
            </router-link>
          </li>



         

        
          <li class="side-nav-item">
            <router-link class="side-nav-link " :to="{ name: 'acceptedInternships' }">

              <i class="uil-package"></i>
              <span class="badge bg-success float-end">{{studentStore.accepted_internships}}</span>
              <span>
                Accepted Internships
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link " :to="{ name: 'refusedInternships' }">
              
              <i class="uil-package"></i>
              <span class="badge bg-danger text-white float-end">{{studentStore.refused_internships}}</span>
              <span>
                Refused Internship
              </span>
            </router-link>
          </li>

        </template>


      </ul>
      <!-- End Sidebar -->

      <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

  </div>
</template>