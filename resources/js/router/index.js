import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import SignUp from "../pages/SignUp.vue";
import PageNotFound from "../pages/PageNotFound.vue";
import CompanySignUp from "../components/signUp/CompanySignUp.vue";
import StudentSignUp from "../components/signUp/StudentSignUp.vue";
import DepartmentSignUp from "../components/signUp/DepartmentSignUp.vue";
import ManageStudentsAccounts from '../components/admin/student/ManageStudentsAccounts.vue';
import Statistiques from "../components/dashboard/Statistiques.vue";
import axios from "axios";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/:pathMatch(.*)*', component: PageNotFound },
    {
      path: "/",
      name: "dashboard",
      component: Dashboard,
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

let isAuth=false;
const checkUserToken = async (token,guard) => {
  const config = {
    headers: {
      'auth-token': token,
      'guard':guard
    }
  }
  await axios.post('/api/loginWithToken/', {}, config).then((response) => {
    isAuth=true;
    window.sessionStorage.setItem('authUser', JSON.stringify(response.data.data))
    window.sessionStorage.setItem('token', response.data.data.token)
  }).catch((error) => {
    console.log(error);
    if(error.response){
      if(error.response.status==450){
        console.log(error.response.data.msg);
      }
    }
  })
}
const guards = ['student', 'campany', 'department', 'super_admin']
router.beforeEach(async (to, from, next) => {


  if (to.name == 'login') {
    if (guards.includes(to.params.guard)) {
      next()
      return
    } else {
      next({ name: "statistiques" })
      return
    }
  }

  if (to.meta.needsAuth) {
    if(from.name=='login'){
      next();
      return
    }
    const token = window.sessionStorage.getItem('token')
    const guard = window.sessionStorage.getItem('guard')
    if (token&&guard) {
      console.log('token',token);
      console.log('guard',guard);
      await checkUserToken(token,guard);
      if(!isAuth){
        next({ name: "login", params: { guard: "student" } })
        return
      }else{
        next()
        return
      }
    } else {
      next({ name: "login", params: { guard: "student" } })
      return
    }
  }
  if (to.meta.notApage) {
    next({ name: "dashboard" })
    return
  }
  next()
})
export default router;