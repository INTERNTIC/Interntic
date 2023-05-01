<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\DepartmentHead;
use App\Models\InternshipResponsible;
use App\Models\PasswordReset;
use App\Models\StudentAccount;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use GeneralTrait;

    public function login(AuthRequest $request, $guard) 
    {
        $request->validated();
        if ($guard == 'student') {
            $account = StudentAccount::where('email', $request->email)->get()->first();
            if ($account==false) {
                return $this->returnError('Your Email is invalid');
            }
            
            if ($account->email_verified == 0) {
                return $this->returnError('Your account is invalid');
            }
        }
        

        $token = auth()->guard($guard)->attempt(['email' => $request->email, 'password' => $request->password]);
        Auth::shouldUse($guard); // this is auth guard currently
        try {
            if (!$token) {
                return $this->returnError('Invalid credentials');
            }
            $user = Auth::guard($guard)->user();

            $user->token = $token;
            $user->guard = $guard;
            return $this->returnData($user);
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
        }
    }





    public function getUserByToken()
    {
        try {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            $guard=Auth::getDefaultDriver();
            $user->token = $token;
            $user->guard = $guard;

            return $this->returnData($user);

        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }



    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            
            if (!$token)
            {
                return $this->returnError('Something was wrong');
            }
            JWTAuth::setToken($token)->invalidate(); 
            // Auth::logoutOtherDevices($token);
            return $this->returnSuccessMessage('Logged out Successfully');
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }




    public function askResetPassword(Request $request,$guard)
    {
        if($guard=='student')
        {
            $account= StudentAccount::where('email', $request->email)->get()->first();
        }
        else
        {
            if($guard=='department_head')
            {
                $account= DepartmentHead::where('email', $request->email)->get()->first();
            }
            else
            {
                if($guard=='super_admin')
                {
                    $account= SuperAdmin::where('email', $request->email)->get()->first();
                }
                else
                {
                    if($guard=='internship_responsibles')
                    {
                        $account= InternshipResponsible::where('email', $request->email)->get()->first();
                    }
                }
            }
        }

        if($account==false) {
            return $this->returnError('Make sure that you have an active account');
        }
        
        $email=$request->email;
        $token = Str::random(64);

        $data=[];
        $data['token']=$token;
        $data['guard']=$guard;

    
        Mail::send('resetPassword',$data ,function($message) use($email)
        {
            $message -> subject('Reset password');
            $message->to($email);
        });

        PasswordReset::create([
            'email'=> $email,
            'token'=> $token,
        ]);


    }



    public function resetPassword(Request $request)
    {
        $token=$request->token;
        $guard=$request->guard;

        $resetAccount= PasswordReset::where('token', $token)->get()->first();

        if($guard=='student')
        {
            $account= StudentAccount::where('email', $resetAccount->email)->get()->first();
        }
        else
        {
            if($guard=='department_head')
            {
                $account= DepartmentHead::where('email', $resetAccount->email)->get()->first();
            }
            else
            {
                if($guard=='super_admin')
                {
                    $account= SuperAdmin::where('email', $resetAccount->email)->get()->first();
                }
            }
        }

        if ($resetAccount==false || $account==false) {
            return $this->returnError('Try again');
        }

        if($request->password==$request->confirme_password)
        {
            Validator::make($request->all(),[                
                'password'=>['required','min:6'],
            ])->validate();
            
            $account->update([ 
                'password'=>Hash::make($request->password)
            ]);
            
            $resetAccount->delete();
        }
        else
        {
            return $this->returnError('Password does not much');
        }
        
    }

}
