<?php


namespace App\Http\Controllers;

use App\Models\DepartmentHead;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\GeneralTrait;

class DepartmentHeadController extends Controller 

{
    use GeneralTrait;

    public function addDepartmentHead(Request $request)
    {
        Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','email','ends_with:univ-constantine2.dz','unique:department_heads'],
            'password'=>['required','min:6'],
            'department_name'=>'required',

        ])->validate();

        $department_id=DB::table('departments')->where('name',$request->department_name)->value('id');

        if($department_id==false)
        {
            return $this->returnError('Make sure about the department name');
        }

        DepartmentHead::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'department_id'=>$department_id,
        ]);
    }

    public function displayDepartmentHeads()
    {
        $department_heads=DB::table('department_heads')->get();
        if($department_heads==false)
        {
            return $this->returnError('No department head to display');
        }
        return $this->returnData($department_heads);
    }

    public function getDepartmentHead($id)
    {
        $department_head=DB::table('department_heads')->where('id',$id)->get();

        if($department_head==false)
        {
            return $this->returnError('Something went wrong');
        }

        return $this->returnData($department_head);
    }

    public function editDepartmentHead(Request $request)
    {
        $departmentHead= DepartmentHead::find($request->id);

        if($departmentHead==false) {
            return $this->returnError('Department head not found');
        }

        $department_id=DB::table('departments')->where('name',$request->department_name)->value('id');

        if($department_id==false)
        {
            return $this->returnError('Make sure about the department name');
        }

        Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','email','ends_with:univ-constantine2.dz','unique:department_heads'],
            'department_name'=>'required',
        ])->validate();
        
        $departmentHead->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'=>$request->email,
            'department_id'=>$department_id,
        ]);
    }

    public function deleteDepartmentHead($id)
    {
        $department_head = DepartmentHead::find($id);

        if ($department_head==false) 
        {
            return $this->returnError('Something went wrong');
        }

        $department_head->delete();
        return $this->returnSuccessMessage('Department head deleted successfully');
    }

    public function departmentheadResetPasword(Request $request,$id)
    {
        $department_head=DepartmentHead::find($id);
        if($department_head==false)
        {
            return $this->returnError('Something went wrong');
        }
        $department_head->update([
            'password'=>Hash::make($request->password),
        ]);
        return $this->returnSuccessMessage('Password updated successfully');
    }
}