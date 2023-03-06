<?php


namespace App\Http\Controllers;

use App\Models\DepartmentHead;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller 
{
    public function superAdminResetPasword(Request $request,$id)
    {
        Validator($request->all(),[
            'old_password'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ])->validate();

        $super_admin=SuperAdmin::find($id);
        if($super_admin==false)
        {
            return $this->returnError('Something went wrong');
        }
       if (Hash::check($request->old_password, $super_admin->password)) {
            $super_admin->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        else
        {
            return $this->returnError('Old password is incorrect');
        }
        return $this->returnSuccessMessage('Password updated successfully');
    }
}