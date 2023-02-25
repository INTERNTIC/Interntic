import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import SignUp from "../pages/SignUp.vue";
import CompanySignUp from "../components/signUp/CompanySignUp.vue";
import StudentSignUp from "../components/signUp/StudentSignUp.vue";
import DepartmentSignUp from "../components/signUp/DepartmentSignUp.vue";
import ManageStudentsAccounts from '../components/admin/student/ManageStudentsAccounts.vue';


import Statistiques from "../components/dashboard/Statistiques.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
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
          path: "/Manage/Student/Account",
          name: "manageStudentsAccounts",
          component: ManageStudentsAccounts,
        },

      ]
    },
    {
      path: "/login/:guard",
      name: "login",
      component: Login,
      // children: [
      //   {
      //     path: "/student/login",
      //     name: "studentLogin",
      //     component: StudentLogin,
      //   },
      //   {
      //     path: "/department/login",
      //     name: "departmentLogin",
      //     component: DepartmentLogin,
      //   },
      //   {
      //     path: "/company/login",
      //     name: "companyLogin",
      //     component: CompanyLogin,
      //   },
      // ]
    },
    {
      path: "/signUp",
      name: "signUp",
      component: SignUp,
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
        },
        {
          path: "/signUp/department",
          name: "departmentSignUp",
          component: DepartmentSignUp,
        }
      ]
    }
  ],
});
// const isStudent=false;
// router.beforeEach((to, from, next) => {
//     // this route requires auth, check if logged in
//     // if not, redirect to login page.
//     if (to.name=='signUp') {
//       if(isStudent){
//         console.log('true');
//         next({
//             name: 'studentSignUp',
//           })
//         }else{
//         console.log('false');
//         next({
//           name: 'companySignUp',
//         })
//       }
//     }else{
//       next();
//     }
// })
const guards=['student','campany','department']
router.beforeEach((to, from, next) => { 
if(to.name=='login'){
  if(guards.includes(to.params.guard)){
    next()
  }else{
  next({name:"statistiques"})
  }
}
next()
})
export default router;