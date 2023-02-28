<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use App\Traits\GeneralTrait;
// use Illuminate\Routing\Controllers\Middleware;

class CheckAuthUser
{
    use GeneralTrait;
 
    public function handle(Request $request, Closure $next,$guard=null)
    {
        $guards=['super_admin','internship_responssible','student','department_head'];
        try {
            if ($guard == null) {
                $guard = $request->header('guard');
            }
            if(!in_array($guard,$guards)){
                return $this->returnError('invalid guard',401);
            }            
            auth()->shouldUse($guard); //shoud you user guard / table
            
            $token = $request->header('auth-token');
            $request->headers->set('auth-token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer ' . $token, true);
            //    $user = $this->auth->authenticate($request);  //check authenticted user
            $user = JWTAuth::parseToken()->authenticate();
            
        } catch (TokenExpiredException $e) {
            return  $this->returnError('Unauthenticated user',401);
        } catch (JWTException $e) {
            return  $this->returnError($e->getMessage(),401);
        } catch (\Throwable $th) {
            return  $this->returnError($th->getMessage(),401);
        }
        return $next($request);
    }
}
