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
        $superAdmin=SuperAdmin::find($id);
        if($superAdmin==false)
        {
            return $this->returnError('Something went wrong');
        }
        $superAdmin->update([
            'password'=>Hash::make($request->password),
        ]);
        return $this->returnSuccessMessage('Password updated successfully');
    }
}