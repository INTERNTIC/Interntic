<?php


namespace App\Http\Controllers;

use App\Http\Requests\DepartmentHeadRequest;
use App\Models\DepartmentHead;
use App\Traits\GeneralTrait;

class DepartmentHeadController extends Controller
{
    use GeneralTrait;

    public function addDepartmentHead(DepartmentHeadRequest $request)
    {
        DepartmentHead::create($request->except("password")+["password"=>bcrypt($request->password)]);
    }

    public function displayDepartmentHeads()
    {
        $department_heads=DepartmentHead::all();
        return $this->returnData($department_heads);
    }

    public function getDepartmentHead($departmentHead)
    {
        return $this->returnData($departmentHead);
    }

    public function editDepartmentHead(DepartmentHeadRequest $request,DepartmentHead $departmentHead)
    {
        $departmentHead->update($request->except("password"));
    }

    public function deleteDepartmentHead($departmentHead)
    {
        $departmentHead->delete();
        return $this->returnSuccessMessage('Department head deleted successfully');
    }

    // public function departmentheadResetPasword(Request $request,$department_head)
    // {
    //     Validator($request->all(),[
    //         'old_password'=>'required',
    //         'password' => 'required|min:6|confirmed',
    //         'password_confirmation' => 'required|min:6'
    //     ])->validate();


    //     if($department_head==false)
    //     {
    //         return $this->returnError('Something went wrong');
    //     }
    //    if (Hash::check($request->old_password, $department_head->password)) {
    //         $department_head->update([
    //             'password'=>Hash::make($request->password),
    //         ]);
    //     }
    //     else
    //     {
    //         return $this->returnError('Old password is incorrect');
    //     }
    //     return $this->returnSuccessMessage('Password updated successfully');
    // }
}