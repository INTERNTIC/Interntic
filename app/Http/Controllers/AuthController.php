<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;


class AuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
    }


    public function login(Request $request, $guard) 
    {
        if ($guard == 'student') {
            $account = StudentAccount::where('email', $request->email)->get()->first();
            if ($account->email_verified == 0) {
                return $this->returnError('Your account is unvalid');
            }
        }

        $token = auth()->guard($guard)->attempt(['email' => $request->email, 'password' => $request->password]);
        try {
            if (!$token) {
                return $this->returnError('Invalid credentials');
            }
            $user = Auth::guard($guard)->user();

            $user->token = $token;
            return $this->returnData($user);
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }





    public function loginWithToken(Request $request)
    {
        try {

            $token=$request->header('auth-token');
            $teacher = Auth::guard('teacher-api')->user();
            $teacher->token = $token;
            return $this->returnData('teacher', $teacher);
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }





    public function logout(Request $request)
    {
        try {
            $token = $request->header('auth-token');
            if (!$token)
                return $this->returnError('Something was wrong');

            JWTAuth::setToken($token)->invalidate();
            return $this->returnSuccessMessage('Logged out Successfully');
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }
}
