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

class InternshipOffersController extends Controller
{
    use GeneralTrait;
    public function addOffer(Request $request)
    {
        $user = Auth::guard('internship_responsible')->user();

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
        $user = Auth::guard('internship_responsible')->user();
        $offers=DB::table('offers')->where('internship_responsible_id',$user->id)->get();

        if($offers==false)
        {
            return $this->returnError('No offer to display');
        }
        return $this->returnData($offers);
    }

    public function selectOffer($id)
    {
        $user = Auth::guard('internship_responsible')->user();
        $offer=DB::table('offers')->where('id',$id)->where('internship_responsible_id',$user->id)->get()->first();
        if($offer==false)
        {
            return $this->returnError('Something went wrong');
        }
        return $this->returnData($offer);
    }

    public function editOffer(Request $request,$id)
    {
        Validator::make($request->all(),[ 
            'theme'=>'required',
            'details'=>'required',
            'duration'=>'required',
        ])->validate();

        $offer=Offer::where('id',$id)->get()->first();

        $offer->update([
            'theme'=>$request->theme,
            'details'=>$request->details,
            'duration'=>$request->duration,
        ]);
    }

    public function deleteOffer($id)
    {
        $offer=Offer::where('id',$id)->get()->first();
        return $offer;

        if($offer==false)
        {
            return $this->returnError('Something went wrong try again');
        }
        $offer->delete();

        if($offer==false)
        {
            return $this->returnSuccessMessage('Offer deleted successfully');
        }
        else
        {
            return $this->returnError('Something went wrong try again');
        }
    }
}