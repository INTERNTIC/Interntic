<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use App\Traits\GeneralTrait;

class CheckAuthUser
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard=null)
    {
        try {
            if ($guard == null) {
                $guard = $request->header('guard');
            }                 
                auth()->shouldUse($guard); //shoud you user guard / table
                $token = $request->header('auth-token');
                $request->headers->set('auth-token', (string) $token, true);
                $request->headers->set('Authorization', 'Bearer ' . $token, true);
                //    $user = $this->auth->authenticate($request);  //check authenticted user
                $user = JWTAuth::parseToken()->authenticate();
            
        } catch (TokenExpiredException $e) {
            return  $this->returnError('Unauthenticated user');
        } catch (JWTException $e) {
            return  $this->returnError('token_invalid' . $e->getMessage());
        } catch (\Throwable $th) {
            return  $this->returnError($th->getMessage());
        }
        return $next($request);
    }
}
