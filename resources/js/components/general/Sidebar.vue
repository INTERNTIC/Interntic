<script setup>
import { useAuthStore } from '@/stores/AuthStore';
import { computed } from 'vue';
const authStore = useAuthStore()
const is_student = computed(
  () => {
    return authStore.userGuard == "student";
  }
)
const is_department_head = computed(
  () => {
    return authStore.userGuard == "department_head";
  }
)
const is_internship_responsible = computed(
  () => {
    return authStore.userGuard == "internship_responsible";
  }
)
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

        <li class="side-nav-title side-nav-item">Navigation</li>

        <li class="side-nav-item">
          <router-link data-bs-toggle="collapse" :to="{ name: 'statistiques' }" aria-expanded="false"
            aria-controls="sidebarDashboards" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span class="badge bg-success float-end">4</span>
            <span> Dashboards </span>
          </router-link>
          <div class="collapse" id="sidebarDashboards">
            <ul class="side-nav-second-level">
              <li>
                <a href="dashboard-analytics.html">Analytics</a>
              </li>
              <li>
                <a href="index.html">Ecommerce</a>
              </li>
              <li>
                <a href="dashboard-projects.html">Projects</a>
              </li>
              <li>
                <a href="dashboard-wallet.html">E-Wallet <span
                    class="badge rounded bg-danger font-10 float-end">New</span></a>
              </li>
            </ul>
          </div>
        </li>

        <li class="side-nav-title side-nav-item">Services</li>


        <li v-if="is_department_head" class="side-nav-item">
          <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce"
            class="side-nav-link">
            <i class="uil-store"></i>
            <span> Manage Students </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarEcommerce">
            <ul class="side-nav-second-level">
              <li>
                <router-link :to="{ name: 'manageStudentsAccounts' }">Manage Students Accounts</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'departmentHeadManageInternshipRequests' }">Manage Internship
                  Requests</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'manageInternshipResponsibleAccounts' }">Manage Internship Responsible
                </router-link>
              </li>

              <li>
                <a href="apps-ecommerce-orders-details.html">Order Details</a>
              </li>
              <li>
                <a href="apps-ecommerce-customers.html">Customers</a>
              </li>
              <li>
                <a href="apps-ecommerce-shopping-cart.html">Shopping Cart</a>
              </li>
              <li>
                <a href="apps-ecommerce-checkout.html">Checkout</a>
              </li>
              <li>
                <a href="apps-ecommerce-sellers.html">Sellers</a>
              </li>
            </ul>
          </div>
        </li>
        <li v-if="is_internship_responsible" class="side-nav-item">
          <a data-bs-toggle="collapse" href="#internship_responsible" aria-expanded="false"
            aria-controls="internship_responsible" class="side-nav-link">
            <i class="uil-store"></i>
            <span> Internship Responsible part</span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="internship_responsible">
            <ul class="side-nav-second-level">
              <li>
                <router-link :to="{ name: 'internshipResponsibleManageInternshipRequests' }">Manage Internship
                  Requests</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'assessStudents' }">Assess Students</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'assessments' }">Manage Assessments</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'marks' }">Manage Marks</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'offers' }">Manage Offers</router-link>
              </li>
              <li>
                <a href="apps-ecommerce-orders-details.html">Order Details</a>
              </li>
              <li>
                <a href="apps-ecommerce-customers.html">Customers</a>
              </li>
              <li>
                <a href="apps-ecommerce-shopping-cart.html">Shopping Cart</a>
              </li>
              <li>
                <a href="apps-ecommerce-checkout.html">Checkout</a>
              </li>
              <li>
                <a href="apps-ecommerce-sellers.html">Sellers</a>
              </li>
            </ul>
          </div>
        </li>

        <template v-if="is_student">

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentInternshipRequests' }">
              <i class="uil-package"></i>
              <span>
                Manage Internship Requests
              </span>
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
                Passed Internships
              </span>
            </router-link>
          </li>

        </template>


      </ul>

      <!-- Help Box -->
      <div class="help-box text-white text-center">
        <a href="javascript: void(0);" class="float-end close-btn text-white">
          <i class="mdi mdi-close"></i>
        </a>
        <img src="/assets/images/help-icon.svg" height="90" alt="Helper Icon Image" />
        <h5 class="mt-3">Unlimited Access</h5>
        <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>
        <a href="javascript: void(0);" class="btn btn-secondary btn-sm">Upgrade</a>
      </div>
      <!-- end Help Box -->
      <!-- End Sidebar -->

      <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

  </div>
</template>