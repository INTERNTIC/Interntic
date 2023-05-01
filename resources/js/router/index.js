import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/AuthStore";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import SignUp from "../pages/SignUp.vue";
import Logout from "../pages/Logout.vue";
import PageNotFound from "../pages/PageNotFound.vue";
import CompanySignUp from "../components/signUp/CompanySignUp.vue";
import StudentSignUp from "../components/signUp/StudentSignUp.vue";
import ManageStudentsAccounts from '../components/departmentHead/ManageStudentsAccounts.vue';
// InternshipResponsible
import InternshipResponsibleManageInternshipRequests from '../components/internshipResponsible/ManageInternshipRequests.vue';
import AssessStudents from '../components/internshipResponsible/AssessStudents.vue';
import InternshipResponsibleAllStudents from '../components/internshipResponsible/AllStudents.vue';
import Assessments from '../components/internshipResponsible/Assessments.vue';
import Marks from '../components/internshipResponsible/Marks.vue';
import Offers from '../components/internshipResponsible/ManageOffers.vue';
// END InternshipResponsible
// departemntHead
import DepartmentHeadManageInternshipRequests from '../components/departmentHead/ManageInternshipRequests.vue';
import ManageInternshipResponsibleAccounts from '../components/departmentHead/ManageInternshipResponsibleAccounts.vue';
// END departemntHead
// Student
import StudentInternshipRequests from '../components/student/ManageInternshipRequests.vue';
import StudentOffers from '../components/student/Offers.vue';
// END Student
import Statistiques from "../components/dashboard/Statistiques.vue";
import {
  redirectToDashboardIfAuth,
  redirectToDefaultLoginGuard,
  wrongGuard,
  nextRouteIfAuth,
} from "./authFunctions.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/:pathMatch(.*)*', name: "PageNotFound", component: PageNotFound },
    {
      path: "/",
      name: "dashboard",
      component: Dashboard,
      children: [
        {
          path: "/",
          name: "statistiques",
          component: Statistiques,
        },
        {
          path: "/departemnt_head",
          meta: {
            guard: "departemnt_head"
          },
          children: [
            {
              path: "Department-head/Manage/Student/Account",
              name: "manageStudentsAccounts",
              component: ManageStudentsAccounts,
            },
            {
              path: "Department-head/Manage/Student/Request",
              name: "departmentHeadManageInternshipRequests",
              component: DepartmentHeadManageInternshipRequests,
            },
            {
              path: "Department-head/Manage/Internship-responsible/Account",
              name: "manageInternshipResponsibleAccounts",
              component: ManageInternshipResponsibleAccounts,
            },
          ]
        },
        // internship responsible part
        {
          path: "/internship_responsible",
          meta: {
            guard: "internship_responsible"
          },
          children: [
            {
              path: "Internship-responsible/Manage/Student/Request",
              name: "internshipResponsibleManageInternshipRequests",
              component: InternshipResponsibleManageInternshipRequests,
            },
            {
              path: "Internship-responsible/Assess/Students",
              name: "assessStudents",
              component: AssessStudents,
            },
            {
              path: "Internship-responsible/Students",
              name: "allStudents",
              component: InternshipResponsibleAllStudents,
            },
            {
              path: "Internship-responsible/Assessments",
              name: "assessments",
              component: Assessments,
            },
            {
              path: "Internship-responsible/Marks",
              name: "marks",
              component: Marks,
            },
            {
              path: "Internship-responsible/Offers",
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
              path: "Student/Internship-requests",
              name: "studentInternshipRequests",
              component: StudentInternshipRequests,
            },
            {
              path: "Student/Offers",
              name: "studentOffers",
              component: StudentOffers,
            },
          ]
        },

      ]
    },


    {
      path: "/login/:guard",
      name: "login",
      component: Login,
      beforeEnter: [
        wrongGuard,
        redirectToDashboardIfAuth
      ],
    },
    {
      path: "/signUp",
      name: "signUp",
      component: SignUp,
      beforeEnter: [redirectToDashboardIfAuth],
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
  if (to.name !== 'login' && !authStore.authUser) {
    // came from a different page or try to refresh 
    // state is cleard and is not going to login
    await nextRouteIfAuth(to, from, next)
  }

  next()
})

export default router;