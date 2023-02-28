import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import SignUp from "../pages/SignUp.vue";
import Logout from "../pages/Logout.vue";
import PageNotFound from "../pages/PageNotFound.vue";
import CompanySignUp from "../components/signUp/CompanySignUp.vue";
import StudentSignUp from "../components/signUp/StudentSignUp.vue";
import DepartmentSignUp from "../components/signUp/DepartmentSignUp.vue";
import ManageStudentsAccounts from '../components/admin/student/ManageStudentsAccounts.vue';
import Statistiques from "../components/dashboard/Statistiques.vue";
import axios from "axios";

import shared from "@/shared.js"



const wrongGuard =(to,from,next)=>{
    if (!shared.guards.includes(to.params.guard)) {
      defaultLoginGuard(to,from,next)
      return
    }
    next()
    return
}


const checkIfAuth= async()=>{
  const sessionToken = window.sessionStorage.getItem('token')
    const sessionGuard = window.sessionStorage.getItem('guard')
    if(sessionToken && sessionGuard){
      await checkUserToken(sessionToken,sessionGuard)
    }else{
      const localToken = window.localStorage.getItem('token')
      const localGuard = window.localStorage.getItem('guard')
      if(localToken && localGuard){
        await checkUserToken(localToken,localGuard)
      }
    }
}


const defaultLoginGuard =(to,from,next)=>{
  const sessionGuard = window.sessionStorage.getItem('guard')
  const localGuard = window.localStorage.getItem('guard')
  if(sessionGuard || localGuard){
    next({ name: "login", params: { guard: sessionGuard==null?localGuard:sessionGuard} })
  }else{
    next({ name: "login", params: { guard: 'student'} })
  }
}
const newLogin= async(to,from,next)=>{
  await checkIfAuth()
  if(isAuth){
    next()
    return;
  }else{
    defaultLoginGuard(to,from,next)
  }
}
const redirectToDashboardIfAuth=async (to,from,next)=>{
  if(from.name!='logout'){
    await checkIfAuth()
     if(isAuth){
        next({name:"dashboard"});
        return
     }
  }
   next()
   return
}
// const redirectToLogin=async (to,from,next)=>{
//   await checkIfAuth()
//    if(isAuth){
//      next()
//      return
//     }
//     next({path:"blabla"});
//    return
// }


// const loginFromLocalStorage = async (to,from,next)=>{
//   const localToken = window.localStorage.getItem('token')
//   const localGuard = window.localStorage.getItem('guard')
//   if (localToken && localGuard) {
//     await checkUserToken(localToken, localGuard);
//      if (!isAuth) {
//       if(shared.guards.includes(localGuard)) {
//         next({ name: "login", params: { guard: localGuard } })
//         return
//       }else{
//         next({ name: "login", params: { guard: 'student' } })
//         return
//       }
//     } 
//   } else {
//     next({ name: "login", params: { guard: "student" } })
//     return
//   }
// }
// const loginFromSessionStorage = async (to,from,next)=>{
//   const sessionToken = window.sessionStorage.getItem('token')
//   const sessionGuard = window.sessionStorage.getItem('guard')
//   if (sessionToken && sessionGuard) {

//     await checkUserToken(sessionToken, sessionGuard);
//     if (!isAuth) {       
//       if(shared.guards.includes(sessionGuard)){
//         next({ name: "login", params: { guard: sessionGuard } })
//         return
//       }else{
//         next({ name: "login", params: { guard: 'student' } })
//         return
//       }
//     }
//   } else {
//     await loginFromLocalStorage(to,from,next)
//   }
//   next()
//   return
// }



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/:pathMatch(.*)*',name:"PageNotFound", component: PageNotFound },
    {
      path: "/",
      name: "dashboard",
      component: Dashboard,
      beforeEnter:[newLogin],
      meta: {
        needsAuth: true,
      },
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
        }
      ]
    },
    {
      path: "/login/:guard",
      name: "login",
      component: Login,
      beforeEnter:[wrongGuard,redirectToDashboardIfAuth],
      meta: {
        notAllowedForAuth : true
      }
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
      beforeEnter:[redirectToDashboardIfAuth],
      meta: {
        notAPage: true,
        notAllowedForAuth:true
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

let isAuth = false;




router.beforeEach(async (to, from, next) => {
  
  if (to.meta.notApage) {
    next({ name: "PageNotFound" })
    return
  }
  next()
})









const checkUserToken = async (token, guard) => {
  const config = {
    headers: {
      'auth-token': token,
      'guard': guard
    }
  }
  await axios.post('/api/loginWithToken/', {}, config).then((response) => {
    isAuth = true;
    window.sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
    window.sessionStorage.setItem('token', response.data.data.token)
    window.sessionStorage.setItem('guard', guard)
  }).catch((error) => {
    console.log(error);
    isAuth = false;
    if (error.response) {
      if (error.response.status == 401) {
      }
    }
  })
}



export default router;