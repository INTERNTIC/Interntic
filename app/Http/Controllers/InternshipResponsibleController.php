<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\InternshipResponssible;
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
        $exist_account=InternshipResponssible::where('email',$request->email)->get()->first();

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

    public function addOffer(Request $request)
    {
        $user = Auth::guard('internship_responssible')->user();

        $responsible_id=$user->id;

        Validator::make($request->all(),[ 
            'theme'=>'required',
            'details'=>'required',
            'duration'=>'required',
        ])->validate();


        Offer::create([
            'theme'=>$request->theme,
            'details'=>$request->details,
            'duration'=>$request->duration,
            'internship_responsible_id'=>$responsible_id
        ]);

    }

    public function displayOffers()
    {
        $user = Auth::guard('internship_responssible')->user();
        $offers=DB::table('offers')->where('internship_responsible_id',$user->id)->get();

        if($offers==false)
        {
            return $this->returnError('No offer to display');
        }
        return $this->returnData($offers);
    }

    public function selectOffer(Request $request)
    {
        $offer=DB::table('offers')->where('id',$request->id)->get()->first();
        return $this->returnData($offer);
    }

    public function editOffer(Request $request)
    {
        Validator::make($request->all(),[ 
            'theme'=>'required',
            'details'=>'required',
            'duration'=>'required',
        ])->validate();

        $offer=Offer::where('id',$request->id)->get()->first();

        $offer->update([
            'theme'=>$request->theme,
            'details'=>$request->details,
            'duration'=>$request->duration,
        ]);
    }

    public function deleteOffer(Request $request)
    {
        $offer=Offer::where('id',$request->id)->get()->first();
        $offer->delete();
    }
}