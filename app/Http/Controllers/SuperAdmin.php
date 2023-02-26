<?php


namespace App\Http\Controllers;

use App\Models\DepartmentHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SuperAdmin extends Controller 
{
    public function addDepartmentHead(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','email','ends_with:univ-constantine2.dz','unique:department_heads'],
            'password'=>['required','min:6'],
            'department_id'=>'required',

        ]);
        
        if($validator->fails()){
            return response()->json(['status' => false,'message'=>'Something went wrong', 'errors' => $validator->errors()]);
        }

        DepartmentHead::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'department_id'=>$request->department_id,
        ]);
    }

    public function editDepartmentHead(Request $request)
    {
        $departmentHead= DepartmentHead::find($request->id);

        if($departmentHead==false) {
            return response()->json(['status' => false,'message'=>'Department head not found']);
        }

        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','email','ends_with:univ-constantine2.dz','unique:department_heads'],
            'department_id'=>'required',
        ]);

        
        if($validator->fails()){
            return response()->json(['status' => false,'message'=>'Something went wrong', 'errors' => $validator->errors()]);
        }
        
        $departmentHead->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'=>$request->email,
            'department_id'=>$request->department_id,
        ]);
    }
}