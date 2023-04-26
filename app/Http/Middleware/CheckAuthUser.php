<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
// use Illuminate\Routing\Controllers\Middleware;

class CheckAuthUser
{
    use GeneralTrait;

    public function handle(Request $request, Closure $next, ...$routeGuards)
    {
        $guards = array_keys(config('auth.guards'));
        try {
            // auth()->shouldUse('super_admin'); //shoud you user guard / table
            //$isAuth= JWTAuth::parseToken()->check(); //this to check if is auth 
            // $token = $request->header('auth-token');
            // $request->headers->set('auth-token', (string) $token, true);
            // $request->headers->set('Authorization', 'Bearer ' . $token, true);
           

            if (!JWTAuth::parseToken()->check()) {
                
                return  $this->returnError(JWTAuth:: authenticate(), 401);
                // return  $this->returnError('Unauthenticated User', 401);
            }
            
           
            if (count($routeGuards) > 0) {
                foreach ($routeGuards as $routeGuard) {
                    if (Auth::guard($routeGuard)->check()) {
                        auth()->shouldUse($routeGuard);
                    }
                }
            }else{
                foreach ($guards as $guard) {
                    if (Auth::guard($guard)->check()) {
                        auth()->shouldUse($guard);
                        // $user = JWTAuth::parseToken()->authenticate();               
                    }
                }

            }

            $user=Auth::authenticate($request);

    
        } catch (TokenExpiredException $e) {
            return  $this->returnError('Unauthenticated user', 401);
        } catch (JWTException $e) {
            return  $this->returnError($e->getMessage(), 401);
        } catch (\Throwable $th) {

            return  $this->returnError($th->getMessage(), 401);
        }
        return $next($request);
    }
}
