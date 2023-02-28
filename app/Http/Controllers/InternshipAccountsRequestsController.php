<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\Company;
use App\Models\InternshipResponsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\GeneralTrait;

class InternshipAccountsRequestsController extends Controller
{
    use GeneralTrait;

    public function displayAccountsRequests()
    {
        $account_requests=AccountRequest::all();
        return $account_requests;
        if($account_requests==false)
        {
            return $this->returnError('No student to display');
        }
        return $this->returnData($account_requests);
    }

    public function getAccountRequest($id)
    {
        $account_request=AccountRequest::find($id);

        if($account_request==false)
        {
            return $this->returnError('Something went wrong');
        }
        
        return $this->returnData($account_request);
    }


    public function manageAccountRequest(Request $request,$id)
    {
        $account_request=AccountRequest::where('id',$id)->get()->first();

        $data=[];
        $email=$account_request->email;
        $data['full_name']=$account_request->first_name." ".$account_request->last_name;
    
        if($request->decision=='accept')
        {
            $company_id=DB::table('companies')->where('name',$account_request->company_name)->where('location',$account_request->company_location)->value('id');
            if($company_id==false)
            {
                Company::create([
                    'name'=>$account_request->company_name,
                    'location'=>$account_request->company_location
                ]);

                $company_id=DB::table('companies')->where('name',$account_request->company_name)->where('location',$account_request->company_location)->value('id');
            }
           
            InternshipResponsible::create([
                'first_name'=>$account_request->first_name,
                'last_name'=>$account_request->last_name,
                'email'=>$account_request->email,
                'password'=>$account_request->password,
                'phone'=>$account_request->phone,
                'company_id'=>$company_id
            ]);

           
            Mail::send('validationAccount',$data ,function($message) use($email)
            {
                $message -> subject('Account validation');
                $message->to($email);
            });

            $account_request->delete();
        }
        else
        {
            Mail::send('refusingAccount',$data ,function($message) use($email)
            {
                $message -> subject('Account Refusing');
                $message->to($email);
            });

            $account_request->delete();
        }
    }
}