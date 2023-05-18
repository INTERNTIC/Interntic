import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/AuthStore";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import SignUp from "../pages/SignUp.vue";
import Logout from "../pages/Logout.vue";
import ResetPassword from "../pages/ResetPassword.vue";
import UpdatePassword from "../pages/UpdatePassword.vue";
import PageNotFound from "../pages/PageNotFound.vue";
import UnauthorizedPage from "../pages/UnauthorizedPage.vue";
import CompanySignUp from "../components/signUp/CompanySignUp.vue";
import StudentSignUp from "../components/signUp/StudentSignUp.vue";
// InternshipResponsible
import InternshipResponsibleManageInternshipRequests from '../components/internshipResponsible/ManageInternshipRequests.vue';
import AssessStudents from '../components/internshipResponsible/AssessStudents.vue';
import InternshipResponsibleAllStudents from '../components/internshipResponsible/AllStudents.vue';
import Assessments from '../components/internshipResponsible/Assessments.vue';
import Marks from '../components/internshipResponsible/Marks.vue';
import Offers from '../components/internshipResponsible/ManageOffers.vue';
import InternshipResponsibleProfile from '../components/internshipResponsible/Profile.vue';
// END InternshipResponsible
// departemntHead
import ManageStudentsAccounts from '../components/departmentHead/ManageStudentsAccounts.vue';
import DepartmentHeadManageInternshipRequests from '../components/departmentHead/ManageInternshipRequests.vue';
import ManageInternshipResponsibleAccounts from '../components/departmentHead/ManageInternshipResponsibleAccounts.vue';
import DepartmentHeadProfile from '../components/departmentHead/Profile.vue';
// END departemntHead
// Student
import StudentInternshipRequests from '../components/student/ManageInternshipRequests.vue';
import StudentOffers from '../components/student/Offers.vue';
import StudentCv from '../components/student/ManageCv.vue';
import PassedInternships from '../components/student/PassedInternships.vue';
import StudentProfile from "../components/student/Profile.vue";
import RefusedInternships from "../components/student/RefusedInternships.vue";
import AcceptedInternships from "../components/student/AcceptedInternships.vue";
// END Student
import Statistiques from "../components/dashboard/Statistiques.vue";
import useAuth from "@/composables/Auth.js";
import { guards } from "@/newShared";

import {
  redirectToDashboardIfAuth,
  wrongGuard,
  nextRouteIfAuth,
  redirectToDefaultLoginGuard
} from "./authFunctions.js";
const openPages=["login", "signUp"];

const { getUserByToken,logout } = useAuth();
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/:pathMatch(.*)*', name: "PageNotFound", component: PageNotFound },
    { path: '/unauthorized', name: "unauthorizedPage", component: UnauthorizedPage },
    {
      path: "/",
      name: "dashboard",
      component: Dashboard,
      meta:{
        needsAuth: true
      },
      children: [
        {
          path: "/update-password",
          name: "updatePassword",
          component: UpdatePassword,
        },
        {
          path: "/",
          name: "statistiques",
          component: Statistiques,
        },
        {
          path: "/profile",
          name: "profile",
          component:  ()=> {
            const authStore = useAuthStore();
            switch (authStore.userGuard) {

              case "internship_responsible":
                return InternshipResponsibleProfile

              case "department_head":
                return DepartmentHeadProfile

              case "student":
                return StudentProfile;

            }
          }
        },
        {
          path: "/department-head",
          meta: {
            guard: "department_head"
          },
          children: [
            {
              path: "manage/student/account",
              name: "manageStudentsAccounts",
              component: ManageStudentsAccounts,
            },
            {
              path: "manage/student/request",
              name: "departmentHeadManageInternshipRequests",
              component: DepartmentHeadManageInternshipRequests,
            },
            {
              path: "manage/internship-responsible/account",
              name: "manageInternshipResponsibleAccounts",
              component: ManageInternshipResponsibleAccounts,
            },
          ]
        },
        // internship responsible part
        {
          path: "/internship-responsible",
          meta: {
            guard: "internship_responsible"
          },
          children: [
            {
              path: "Manage/Student/Request",
              name: "internshipResponsibleManageInternshipRequests",
              component: InternshipResponsibleManageInternshipRequests,
            },
            {
              path: "assess/students",
              name: "assessStudents",
              component: AssessStudents,
            },
            {
              path: "students",
              name: "allStudents",
              component: InternshipResponsibleAllStudents,
            },
            {
              path: "assessments",
              name: "assessments",
              component: Assessments,
            },
            {
              path: "marks",
              name: "marks",
              component: Marks,
            },
            {
              path: "offers",
              name: "offers",
              component: Offers,
            },
          ]

        },
        // student part 

        {
          path: "/student",
          meta: {
            guard: "student"
          }, children: [
            {
              path: "internships/refused",
              name: "refusedInternships",
              component: RefusedInternships,
            },
            {
              path: "internships/requested",
              name: "studentInternshipRequests",
              component: StudentInternshipRequests,
            },
            {
              path: "offers",
              name: "studentOffers",
              component: StudentOffers,
            },
            {
              path: "Cv",
              name: "studentCv",
              component: StudentCv,
            },
            {
              path: "internships/passed",
              name: "passedInternships",
              component: PassedInternships,
            },
            {
              path: "internships/accepted",
              name: "acceptedInternships",
              component: AcceptedInternships,
            },
          ]
        },
        
      ]
    },
    {
      path: "/reset-password",
      name: "resetPassword",
      component: ResetPassword,
    },

    {
      path: "/login/:guard",
      name: "login",
      component: Login,
    },
    {
      path: "/logout",
      name: "logout",
      component: Logout,
    },
    {
      path: "/signUp",
      name: "signUp",
      component: SignUp,
      // beforeEnter: [redirectToDashboardIfAuth],
      meta: {
        notAPage: true,
      },
      children: [
        {
          path: "/signUp",
          name: "studentSignUp",
          component: StudentSignUp,
        },
        {
          path: "/signUp/company",
          name: "companySignUp",
          component: CompanySignUp,
        }
      ]
    }
  ],
});


router.beforeEach(async (to, from, next) => {


  if (to.meta.notApage) {
    next({ name: "PageNotFound" })
    return
  }
  const authStore = useAuthStore();


  if (authStore.authUser) {
    if (openPages.includes(to.name)) {
      next({ name: "statistiques" })
      return
    }
  } else {

    let token = sessionStorage.getItem('token') ?? localStorage.getItem('token');
    // if token exist try to authenticate
    if (token != null) {
      await getUserByToken(token)
      // check if user is authenticated (token was valid)   
      if (authStore.authUser) {
        if (openPages.includes(to.name)) {
          next({ name: "statistiques" })
          return
        }
      }
    }
  }

  if (to.meta.guard) {
    if (authStore.userGuard != null && authStore.userGuard != to.meta.guard) {
      console.log("noooooooooooooo to guard , userGaudAuth", to.meta.guard, authStore.userGuard);
      next({ name: "statistiques" })
      return
    }
  }

  if (to.meta.needsAuth) {
    if (!authStore.authUser) {
      redirectToDefaultLoginGuard(to, from, next)
      return
    }
  }

  // this should be the last
  if (to.name == "login") {
    if (!guards.includes(to.params.guard)) {
      redirectToDefaultLoginGuard(to, from, next)
      return
    }
  }


  next()
})

export default router;