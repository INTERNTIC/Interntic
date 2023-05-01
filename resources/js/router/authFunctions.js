import { guards } from "@/newShared";
import { useAuthStore } from "../stores/AuthStore";

export const wrongGuard = (to, from, next) => {
  if (!guards.includes(to.params.guard)) {
    redirectToDefaultLoginGuard(to, from, next)
    return
  }
  next()
}
export const redirectToDefaultLoginGuard = (to, from, next) => {
  let guard = localStorage.getItem('guard')
  // if guard is null set it to defult guard
  guard = guard ?? "student";
  next({ name: "login", params: { guard: guard } })

}
export const redirectToDashboardIfAuth = async (to, from, next) => {
  // redirect user to dashboard if he is authenticated
  const authStore = useAuthStore()
  if (authStore.authUser) {
    next({ name: "statistiques" });
  } else {
    // if user have a token then authenticate him by it 
    let token = sessionStorage.getItem('token') ?? localStorage.getItem('token');
    // if token exist try to authenticate
    if (token != null) {
      await authStore.getUserByToken(token)
      // check if user is authenticated (token was valid)
      if (authStore.authUser) {        
        next({ name: "statistiques" });
      }
    } 
  }
  next()
}
export const nextRouteIfAuth = async (to, from, next) => {
 // redirect user to next page if he is auth
 // if user have a token then authenticate him by it 
 const authStore = useAuthStore()
 let token = sessionStorage.getItem('token') ?? localStorage.getItem('token');
 // if token exist try to authenticate
 if (token != null) {
   
   await authStore.getUserByToken(token)
   // check if user is authenticated (token was valid)   
   if (!authStore.authUser) { 
     // Login
    //  next({name: 'login',params:{guard:"student"}})
     redirectToDefaultLoginGuard(to,from,next)
   }

 } else {
   // go to login page
  //  next({name: 'login',params:{guard:"student"}})
   redirectToDefaultLoginGuard(to,from,next)
 }
 if (to.meta.guard) {
  if (authStore.userGuard != null && authStore.userGuard != to.meta.guard) {
    next({name:"statistiques"})
    next(authStore.userGuard != null && authStore.userGuard != to.meta.guard)
    console.log("noooooooooooooooooo ", to.meta.guard, authStore.userGuard);
  }
}

}


