<script setup>
import Sidebar from '../components/general/Sidebar.vue';
import Topbar from '../components/general/Topbar.vue';
import Content from '../components/general/Content.vue';
import SettingSidebar from '../components/general/SettingSidebar.vue';

import { useAuthStore } from '../stores/AuthStore';
const AuthStore = useAuthStore();


</script>
<template>
  <!-- Begin page -->
  <div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <Sidebar />
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">
        <!-- Topbar Start -->
        <Topbar />
        <!-- end Topbar -->
        <!-- Start Content-->
        <div class="container-fluid">
          <Content/>
        </div>
        <!-- container -->

      </div>
      <!-- content -->

      <!-- Footer Start -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              2023 © Hyper - Coderthemes.com
            </div>
            <div class="col-md-6">
              <div class="text-md-end footer-links d-none d-md-block">
                <a href="javascript: void(0);">About</a>
                <a href="javascript: void(0);">Support</a>
                <a href="javascript: void(0);">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


  </div>
  <!-- END wrapper -->

  <!-- Right Sidebar -->
<SettingSidebar/>

  <div class="rightbar-overlay"></div>
  <!-- /End-bar -->
</template>
