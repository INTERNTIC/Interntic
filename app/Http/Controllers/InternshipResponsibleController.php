<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InternshipResponsibleController extends Controller
{
    public function accountRequest(Request $request)
    {
        Validator::make($request->all(),[ 
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','unique:internship_responssibles'],
            'password'=>['required','min:6'],
            'phone'=>'required',
            'company_name'=>'required',
            'company_location'=>'required',
        ])->validate();

        AccountRequest::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone,
            'company_name'=>$request->company_name,
            'company_location'=>$request->company_location,
        ]);
    }
}