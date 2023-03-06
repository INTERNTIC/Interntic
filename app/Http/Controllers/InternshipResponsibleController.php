<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\InternshipResponsible;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;

class InternshipResponsibleController extends Controller
{
    use GeneralTrait;
    public function accountRequest(Request $request) 
    {
        Validator::make($request->all(),[ 
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','unique:account_requests'],
            'password'=>['required','min:6'],
            'phone_number'=>'required',
            'company_name'=>'required',
            'company_location'=>'required',
        ])->validate();

        $account_request=AccountRequest::where('email',$request->email)->get()->first();
        $exist_account=InternshipResponsible::where('email',$request->email)->get()->first();

        if($account_request==true) 
        {
            return $this->returnError('You already have sent a request!');
        }

        if($exist_account==true)
        {
            return $this->returnError('You already have have an account!');   
        }


        AccountRequest::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone_number,
            'company_name'=>$request->company_name,
            'company_location'=>$request->company_location,
        ]);
    }

    public function responsibleResetPasword(Request $request,$id)
    {
        Validator($request->all(),[
            'old_password'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ])->validate();

        $internship_responsible=InternshipResponsible::find($id);
        if($internship_responsible==false)
        {
            return $this->returnError('Something went wrong');
        }
       if (Hash::check($request->old_password, $internship_responsible->password)) {
            $internship_responsible->update([
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