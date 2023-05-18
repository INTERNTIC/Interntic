<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Support\Str;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\DepartmentHead;
use App\Models\StudentAccount;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipResponsible;
use App\Http\Resources\StudentResource;
use App\Http\Resources\DepartmentHeadResource;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\InternshipResponsibleResource;
use App\Traits\SendEmail;

class AuthController extends Controller
{
    use GeneralTrait;
    use SendEmail;

    public function login(AuthRequest $request, $guard)
    {
        if ($guard == 'student') {
            $account = StudentAccount::where('email', $request->email)->first();
            if (!$account) {
                return $this->returnError('Your Email is invalid');
            }

            if ($account->email_verified == 0) {
                return $this->returnError('Your account is unverified');
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


            switch ($guard) {
                case config("global.student_guard"):
                    $student = $user->student;
                    $student->token = $token;
                    $student->guard = $guard;
                    return $this->returnData(new StudentResource($student));


                case config("global.department_head_guard"):
                    return $this->returnData(new DepartmentHeadResource($user));


                case config("global.internship_responsible_guard"):
                    return $this->returnData(new InternshipResponsibleResource($user));
            }
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
        }
    }





    public function getUserByToken()
    {
        try {
            $user = Auth::user();
            $guard = Auth::getDefaultDriver();
            $token = JWTAuth::fromUser($user);
            $user->token = $token;
            $user->guard = $guard;

            switch ($guard) {
                case config("global.student_guard"):
                    $student = $user->student;
                    $student->token = $token;
                    $student->guard = $guard;
                    return $this->returnData(new StudentResource($student));
                    break;

                case config("global.department_head_guard"):
                    return $this->returnData(new DepartmentHeadResource($user));
                    break;

                case config("global.internship_responsible_guard"):
                    return $this->returnData(new InternshipResponsibleResource($user));
                    break;
            }
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }



    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();

            if (!$token) {
                return $this->returnError('Something was wrong');
            }
            JWTAuth::setToken($token)->invalidate();
            // Auth::logoutOtherDevices($token);
            return $this->returnSuccessMessage('Logged out Successfully');
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage(), $th->getCode());
        }
    }


    public function getAccount($email, $guard)
    {
        $account = null;
        switch ($guard) {
            case 'student':
                $account = StudentAccount::where('email', $email)->first();

            case 'department_head':
                $account = DepartmentHead::where('email', $email)->first();

            case 'super_admin':
                $account = SuperAdmin::where('email', $email)->first();

            case 'internship_responsible':
                $account = InternshipResponsible::where('email', $email)->first();
        }
        return $account??$this->returnError("wrong Email");
        
    }

    public function forgetPassword(Request $request, $guard)
    {
        // validate the request
        try {

            $this->getAccount($request->email, $guard);

            $email = $request->email;
            $token = Str::random(64);

            $data = [];
            $data['token'] = $token;
            $data['guard'] = $guard;


            $this->sendEmail($data, $email, "resetPassword", "Reset password");

            PasswordReset::create([
                'email' => $email,
                'token' => $token,
            ]);
            return $this->returnSuccessMessage("please check your inbox",);
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
            return $this->returnError("please verify your Connection and try again",);
        }
    }



    public function updatePassword(Request $request)
    {

        $request->validate([
            "old_password" => ['required','current_password'],
            'password' => ['required', "confirmed", 'min:6'],
        ]);
        

        $user=auth()->user();

        

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return $this->returnSuccessMessage("password changed successfully");
    }
    public function resetPassword(Request $request)
    {

        $request->validate([
            // TODO guard should be in array
            "token" => ['required', 'exists:password_resets,token'],
            "guard" => ['required'],
            "email" => ['required'],
            'password' => ['required', "confirmed", 'min:6'],
        ]);
        $token = $request->token;
        $guard = $request->guard;

        $resetAccount = PasswordReset::where('token', $token)->get()->first();

        $account = $this->getAccount($request->email, $guard);

        $account->update([
            'password' => bcrypt($request->password)
        ]);

        $resetAccount->delete();
        return $this->returnSuccessMessage("password changed successfully");
    }
}
